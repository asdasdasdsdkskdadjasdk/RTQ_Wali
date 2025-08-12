<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InjectSweetAlert
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \Symfony\Component\HttpFoundation\Response $response */
        $response = $next($request);

        if ($this->isHtmlResponse($response) && $this->hasBodyTag($response)) {
            $success = $request->session()->get('success');
            $error   = $request->session()->get('error');
            $info    = $request->session()->get('info');
            $warning = $request->session()->get('warning');

            $script = $this->buildScript($success, $error, $info, $warning);

            $content = $response->getContent();
            // sisipkan tepat sebelum </body>
            $content = preg_replace('/<\/body\s*>/i', $script . '</body>', $content, 1);
            $response->setContent($content);
        }

        return $response;
    }

    protected function isHtmlResponse(Response $response): bool
    {
        $type = $response->headers->get('Content-Type');
        return $type && str_contains($type, 'text/html');
    }

    protected function hasBodyTag(Response $response): bool
    {
        return stripos($response->getContent(), '</body>') !== false;
    }

    protected function buildScript($success, $error, $info, $warning): string
    {
        $successJs = json_encode($success);
        $errorJs   = json_encode($error);
        $infoJs    = json_encode($info);
        $warnJs    = json_encode($warning);

        return <<<HTML
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
(function () {
  var msg = {
    success: {$successJs},
    error: {$errorJs},
    info: {$infoJs},
    warning: {$warnJs}
  };

  // Tampilkan flash otomatis
  if (msg.success) {
    Swal.fire({ icon: 'success', title: 'Berhasil', text: msg.success, showConfirmButton: false, timer: 2000 });
  }
  if (msg.error) {
    Swal.fire({ icon: 'error', title: 'Gagal', text: msg.error, showConfirmButton: true });
  }
  if (msg.info) {
    Swal.fire({ icon: 'info', title: 'Info', text: msg.info, showConfirmButton: true });
  }
  if (msg.warning) {
    Swal.fire({ icon: 'warning', title: 'Perhatian', text: msg.warning, showConfirmButton: true });
  }

  // Konfirmasi hapus universal
  // a) Klik tombol dengan data-confirm="delete" atau .btn-delete
  document.addEventListener('click', function (e) {
    var btn = e.target.closest('[data-confirm="delete"], .btn-delete');
    if (!btn) return;
    var form = btn.closest('form');
    if (!form) return;
    e.preventDefault();
    Swal.fire({
      title: 'Yakin hapus data ini?',
      text: 'Data yang dihapus tidak bisa dikembalikan!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal'
    }).then(function (r) { if (r.isConfirmed) form.submit(); });
  }, true);

  // b) Deteksi otomatis FORM yang spoof DELETE (tanpa perlu ubah view)
  document.addEventListener('submit', function (e) {
    var f = e.target;
    if (!f) return;
    // skip kalau developer sengaja menambahkan data-skip-delete-confirm
    if (f.hasAttribute('data-skip-delete-confirm')) return;

    var isDeleteSpoof = f.querySelector('input[name="_method"][value="DELETE"]');
    if (isDeleteSpoof) {
      e.preventDefault();
      Swal.fire({
        title: 'Yakin hapus data ini?',
        text: 'Data yang dihapus tidak bisa dikembalikan!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then(function (r) { if (r.isConfirmed) f.submit(); });
    }
  }, true);
})();
</script>
HTML;
    }
}
