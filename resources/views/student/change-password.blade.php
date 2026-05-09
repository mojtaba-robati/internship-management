<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تغییر رمز عبور</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    <link href="https://cdn.jsdelivr.net/npm/vazirmatn@33.0.1/Vazirmatn-font-face.css" rel="stylesheet">
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card shadow" style="width: 400px;">
            <div class="card-header bg-warning text-center">
                <h4>⚠️ تغییر رمز عبور الزامی است</h4>
            </div>
            <div class="card-body">
                <p class="text-muted text-center">
                    برای اولین بار که وارد سیستم می‌شوید، باید رمز عبور خود را تغییر دهید.
                </p>
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                    </div>
                @endif
                
                <form method="POST" action="{{ route('student.change-password.submit') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">رمز عبور جدید</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">تکرار رمز عبور جدید</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">تغییر رمز عبور</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>