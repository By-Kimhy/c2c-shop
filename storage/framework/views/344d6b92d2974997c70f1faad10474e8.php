
<?php $__env->startSection('content'); ?>

<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>Payment (KHQR)</h1>
                <nav class="d-flex align-items-center">
                    <a href="<?php echo e(route('home')); ?>">Home<span class="lnr lnr-arrow-right"></span></a>
                    <a href="<?php echo e(route('checkout')); ?>">Checkout</a>
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
                <p>Order: <strong><?php echo e($order->order_number ?? $order->id); ?></strong></p>
                <p>Amount: <strong><?php echo e(number_format($order->total,2)); ?> $</strong></p>
                <?php if(!empty($payment) && !empty($payment->provider_ref)): ?>
                    <p>Payment ref: <strong><?php echo e($payment->provider_ref); ?></strong></p>
                <?php endif; ?>
            </div>

            <div class="col-md-6 text-center">
                <?php if(!empty($qrData)): ?>
                    <img src="data:image/png;base64,<?php echo e($qrData); ?>" alt="KHQR" style="max-width:320px;">
                <?php elseif(!empty($payload)): ?>
                    <?php
                        $encoded = rawurlencode($payload);
                        $size = 350;
                        $chartUrl = "https://chart.googleapis.com/chart?cht=qr&chs={$size}x{$size}&chl={$encoded}&chld=L|1";
                    ?>
                    <img src="<?php echo e($chartUrl); ?>" alt="KHQR fallback" style="max-width:320px;">
                <?php elseif(!empty($qrRaw)): ?>
                    <pre style="white-space:pre-wrap; word-break:break-word;"><?php echo e($qrRaw); ?></pre>
                <?php else: ?>
                    <div class="alert alert-warning">No QR available</div>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-3">
            <a href="<?php echo e(route('home')); ?>" class="btn btn-link">Back to home</a>
            <a href="<?php echo e(route('checkout')); ?>" class="btn btn-outline-secondary">Back to checkout</a>
        </div>

        <?php
            $md5Val = $md5 ?? null;
            if (!$md5Val && isset($payment) && $payment->payload) {
                $pl = is_array($payment->payload) ? $payment->payload : (json_decode($payment->payload, true) ?: []);
                $md5Val = $pl['md5'] ?? $pl['khqr_payload_md5'] ?? null;
            }
        ?>

        <?php if($md5Val): ?>
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
                        const resp = await fetch("<?php echo e(route('khqr.check_md5')); ?>", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>"
                            },
                            body: JSON.stringify({ md5: "<?php echo e($md5Val); ?>" })
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
        <?php endif; ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layout.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\E-commerce\c2c-shop - Copy\resources\views/frontend/checkout/khqr.blade.php ENDPATH**/ ?>