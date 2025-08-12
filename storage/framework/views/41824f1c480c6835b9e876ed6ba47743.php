<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RTQ Al Yusra | Login</title>
    <link rel="shortcut icon" href="<?php echo e(asset('img/image/logortq.png')); ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-image: url('<?php echo e(asset('img/image/rtq_bg.jpeg')); ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            font-family: Arial, sans-serif;
            background-color: rgba(128, 128, 128, 0.4);
            backdrop-filter: blur(3px);
        }
    </style>
</head>

<body>
    <div class="lr-container">
        <div class="lr-box">
            <img src="img/image/logortq.png" alt="Logo RTQ Al Yusra" class="logo">
            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>
                <?php if($errors->any()): ?>
                    <div class="alert-box">
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <input type="email" name="email" placeholder="Enter your email" required>
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
                <label class="show-password">
                    <input type="checkbox" onclick="togglePassword()"> Show Password
                </label>
                <button type="submit" class="lr-button">Login</button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById("password");
            password.type = password.type === "password" ? "text" : "password";
        }
    </script>
</body>

</html><?php /**PATH D:\Sistem\sistemrtq\resources\views/auth/login.blade.php ENDPATH**/ ?>