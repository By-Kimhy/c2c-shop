<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminST5 | @yield('title')</title>

    @include('backend.layout.styleshop')

</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        @include('backend.layout.header')

        @include('backend.layout.leftsidebar')

        @yield('content')

        @include('backend.layout.footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    @include('backend.layout.jsshop')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function getCsrfToken() {
                const el = document.querySelector('meta[name="csrf-token"]');
                return el ? el.getAttribute('content') : '';
            }

            // Delegate: handle click for dynamic rows too
            document.body.addEventListener('click', function(e) {
                const btn = e.target.closest('.js-delete-user');
                if (!btn) return;
                e.preventDefault();

                const id = btn.dataset.id;
                if (!id) {
                    alert('Missing user id');
                    return;
                }

                if (!confirm('Delete user #' + id + '?')) return;

                const token = getCsrfToken();
                if (!token) {
                    alert('CSRF token not found. Ensure <meta name="csrf-token"> is in <head>.');
                    return;
                }

                btn.disabled = true;
                const originalText = btn.textContent;
                btn.textContent = 'Deleting...';

                fetch('/admin/users/' + id, {
                        method: 'POST', // Laravel uses POST with _method=DELETE
                        headers: {
                            'Accept': 'application/json'
                            , 'Content-Type': 'application/json'
                            , 'X-CSRF-TOKEN': token
                        }
                        , body: JSON.stringify({
                            _method: 'DELETE'
                        })
                    })
                    .then(async res => {
                        if (res.status === 200 || res.status === 204 || res.status === 302) return res;
                        if (res.status === 419) throw new Error('CSRF token mismatch (419).');
                        let j;
                        try {
                            j = await res.json();
                        } catch (e) {}
                        throw new Error((j && j.message) ? j.message : 'Delete failed');
                    })
                    .then(() => {
                        // remove table row if in list view; otherwise redirect to index
                        const row = btn.closest('tr[data-user-id]');
                        if (row) row.remove();
                        else window.location.href = '/admin/users';
                    })
                    .catch(err => {
                        alert('Delete failed: ' + err.message);
                        console.error(err);
                        btn.disabled = false;
                        btn.textContent = originalText;
                    });
            });
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.body.addEventListener('click', function(e) {
                const btn = e.target.closest('.js-toggle-approve');
                if (!btn) return;
                e.preventDefault();

                const id = btn.dataset.id;
                if (!id) return;

                if (!confirm('Toggle approval for seller #' + id + '?')) return;

                const token = document.querySelector('meta[name="csrf-token"]') ? .getAttribute('content') || '';

                fetch('/admin/sellers/' + id + '/toggle-approve', {
                        method: 'POST'
                        , headers: {
                            'Accept': 'application/json'
                            , 'Content-Type': 'application/json'
                            , 'X-CSRF-TOKEN': token
                        }
                        , body: JSON.stringify({})
                    })
                    .then(r => r.json())
                    .then(json => {
                        if (json.is_approved === 1 || json.is_approved === '1') {
                            btn.textContent = 'Suspend';
                            btn.closest('tr').querySelector('td:nth-child(4)').innerHTML = '<span class="badge badge-success">Approved</span>';
                        } else {
                            btn.textContent = 'Approve';
                            btn.closest('tr').querySelector('td:nth-child(4)').innerHTML = '<span class="badge badge-secondary">Pending</span>';
                        }
                        alert(json.message || 'Done');
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Failed to toggle approval.');
                    });
            });
        });

    </script>


</body>
</html>
