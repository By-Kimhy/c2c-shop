@extends('frontend.layout.master')
@section('content')

<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Payment (KHQR)</h1>
                <nav class="d-flex align-items-center">
                    <a href="{{ route('home') }}">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="{{ route('checkout') }}">Checkout</a>
                </nav>
            </div>
        </div>
    </div>
</section>


<div class="container py-4">
    <h3>Scan QR to pay</h3>

    <div class="card p-4">
        <div class="row">
            <div class="col-md-6">
                <p>Order: <strong>{{ $order->order_number ?? $order->id }}</strong></p>
                <p>Amount: <strong>{{ number_format($order->total,2) }} $</strong></p>
                @if(!empty($payment) && !empty($payment->provider_ref))
                <p>Payment ref: <strong>{{ $payment->provider_ref }}</strong></p>
                @endif
            </div>

            <div class="col-md-6 text-center">
                @if(!empty($qrData))
                <img src="data:image/png;base64,{{ $qrData }}" alt="KHQR" style="max-width:320px;">
                @elseif(!empty($payload))
                @php
                $encoded = rawurlencode($payload);
                $size = 350;
                $chartUrl = "https://chart.googleapis.com/chart?cht=qr&chs={$size}x{$size}&chl={$encoded}&chld=L|1";
                @endphp
                <img src="{{ $chartUrl }}" alt="KHQR fallback" style="max-width:320px;">
                @elseif(!empty($qrRaw))
                <pre style="white-space:pre-wrap; word-break:break-word;">{{ $qrRaw }}</pre>
                @else
                <div class="alert alert-warning">No QR available</div>
                @endif
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('home') }}" class="btn btn-link">Back to home</a>
            <a href="{{ route('checkout') }}" class="btn btn-outline-secondary">Back to checkout</a>
        </div>

        @php
        $md5Val = $md5 ?? null;
        if (!$md5Val && isset($payment) && $payment->payload) {
        $pl = is_array($payment->payload) ? $payment->payload : (json_decode($payment->payload, true) ?: []);
        $md5Val = $pl['md5'] ?? $pl['khqr_payload_md5'] ?? null;
        }
        @endphp

        {{-- @if($md5Val)
            <div class="mt-3">
                <button id="check-payment-btn" class="btn btn-primary">Check payment</button>
                <span id="check-status" class="ms-2"></span>
            </div>

            <script>
                document.getElementById('check-payment-btn').addEventListener('click', async function () {
                    const btn = this;
                    btn.disabled = true;
                    document.getElementById('check-status').textContent = 'Checking...';

                    try {
                        const resp = await fetch("{{ route('khqr.check_md5') }}", {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        body: JSON.stringify({ md5: "{{ $md5Val }}" })
        });
        const json = await resp.json();
        if (json.ok) {
        document.getElementById('check-status').textContent = json.message || 'Paid';
        } else {
        document.getElementById('check-status').textContent = json.message || 'Not paid';
        }
        } catch (err) {
        document.getElementById('check-status').textContent = 'Error checking payment';
        console.error(err);
        } finally {
        btn.disabled = false;
        }
        });
        </script>
        @endif --}}

        @if($md5Val)
        <div class="mt-3">
            <span id="check-status" class="text-muted">Waiting for payment...</span>
        </div>

        <script>
            (function() {
                const MD5_VALUE = "{{ $md5Val }}";
                const CHECK_URL = "{{ route('khqr.check_md5') }}";
                const CSRF = "{{ csrf_token() }}"; // still useful, but we also send cookies

                const statusEl = document.getElementById('check-status');
                if (!statusEl) return;

                let checking = false;
                let intervalId = null;
                let pollInterval = 3000; // ms
                let consecutiveErrors = 0;

                function setStatus(text, cls = 'text-muted') {
                    statusEl.textContent = text;
                    statusEl.classList.remove('text-muted', 'text-success', 'text-danger');
                    if (cls) statusEl.classList.add(cls);
                }

                async function checkPaymentOnce() {
                    if (checking) return;
                    checking = true;
                    try {
                        console.debug('[KHQR] checking md5:', MD5_VALUE);

                        const resp = await fetch(CHECK_URL, {
                            method: 'POST'
                            , credentials: 'same-origin', // important: send cookies so Laravel CSRF passes
                            headers: {
                                'Content-Type': 'application/json'
                                , 'X-CSRF-TOKEN': CSRF
                                , 'X-Requested-With': 'XMLHttpRequest'
                            }
                            , body: JSON.stringify({
                                md5: MD5_VALUE
                            })
                        });

                        console.debug('[KHQR] response status:', resp.status);

                        if (resp.status === 419) {
                            // CSRF / session problem
                            setStatus('Session expired or CSRF mismatch. Please reload the page.', 'text-danger');
                            console.error('KHQR check returned 419 (CSRF).');
                            stopPolling();
                            checking = false;
                            return;
                        }

                        if (!resp.ok) {
                            // server returned 4xx/5xx
                            const text = await resp.text().catch(() => '');
                            setStatus('Server error checking payment', 'text-danger');
                            console.error('KHQR check server error', resp.status, text);
                            consecutiveErrors++;
                            // exponential backoff up to 30s
                            pollInterval = Math.min(30000, 3000 * Math.pow(2, Math.min(5, consecutiveErrors)));
                            restartPollingInterval();
                            checking = false;
                            return;
                        }

                        const json = await resp.json().catch(() => null);
                        console.debug('[KHQR] response json:', json);

                        if (!json) {
                            setStatus('Invalid response from server', 'text-danger');
                            consecutiveErrors++;
                            restartPollingInterval();
                            checking = false;
                            return;
                        }

                        if (json.ok) {
                            setStatus('Payment received ✔', 'text-success');
                            console.info('[KHQR] payment ok', json);
                            // stop polling
                            stopPolling();
                            // optionally you can fetch updated order info here or show a button to view order
                            return;
                        } else {
                            // still not paid
                            setStatus(json.message || 'Waiting for payment...', 'text-muted');
                            consecutiveErrors = 0;
                            pollInterval = 3000; // reset to default
                            restartPollingInterval();
                        }
                    } catch (err) {
                        console.error('[KHQR] check failed', err);
                        setStatus('Network error checking payment', 'text-danger');
                        consecutiveErrors++;
                        restartPollingInterval();
                    } finally {
                        checking = false;
                    }
                }

                function stopPolling() {
                    if (intervalId) {
                        clearInterval(intervalId);
                        intervalId = null;
                    }
                }

                function restartPollingInterval() {
                    stopPolling();
                    intervalId = setInterval(checkPaymentOnce, pollInterval);
                }

                // start
                setStatus('Waiting for payment...', 'text-muted');
                // run immediately
                checkPaymentOnce();
                // then poll
                intervalId = setInterval(checkPaymentOnce, pollInterval);
            })();

        </script>


        @endif


    </div>
</div>
@endsection
