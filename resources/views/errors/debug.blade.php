<!DOCTYPE html>
<html>
<head>
    <title>Debug Error</title>
    <style>
        body { font-family: monospace; margin: 20px; background: #f0f0f0; }
        .error-box { background: white; padding: 20px; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .error-title { color: #dc3545; font-size: 24px; margin-bottom: 10px; }
        .error-message { background: #fff3cd; padding: 10px; border-radius: 3px; margin: 10px 0; }
        .error-file { color: #6c757d; font-size: 14px; }
        .trace { margin-top: 20px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="error-box">
        <div class="error-title">🚨 DEBUG ERROR - {{ app()->environment() }}</div>
        
        <div class="error-message">
            <strong>Message:</strong> {{ $error->getMessage() }}
        </div>
        
        <div class="error-file">
            <strong>File:</strong> {{ $error->getFile() }}:{{ $error->getLine() }}
        </div>
        
        <div class="trace">
            <strong>Stack Trace:</strong>
            <pre>{{ $error->getTraceAsString() }}</pre>
        </div>
        
        <div style="margin-top: 20px;">
            <a href="/" style="color: #007bff; text-decoration: none;">← Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>