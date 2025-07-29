<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['username'] === 'admin' && $_POST['password'] === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Login gagal. Username atau Password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Admin KPPN Dumai</title>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(-45deg, #004080, #006699, #003366, #002244);
      background-size: 400% 400%;
      animation: gradientBG 10s ease infinite;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .login-box {
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(15px);
      border-radius: 20px;
      padding: 40px 35px;
      width: 100%;
      max-width: 400px;
      color: #fff;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
      position: relative;
      animation: fadeIn 1s ease;
      transition: transform 0.2s;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .logo {
  position: absolute;
  top: -65px;
  left: calc(50% - 30px);
  width: 60px;
  height: 60px;
  /* URL lama kamu (biarkan) */
  background: url('https://www.google.com/url?....') no-repeat center center;

  /* Tambahan URL langsung ke gambar PNG (ini yang dipakai browser) */
  background: url('https://upload.wikimedia.org/wikipedia/commons/thumb/7/73/Logo_Kementerian_Keuangan_Republik_Indonesia.svg/1200px-Logo_Kementerian_Keuangan_Republik_Indonesia.svg.png') no-repeat center center;
  background-size: contain;
}


    .mascot {
      position: absolute;
      top: -120px;
      left: calc(50% - 40px);
      width: 80px;
      height: 80px;
      background: url('https://www.google.com/url?sa=i&url=https%3A%2F%2Fid.wikipedia.org%2Fwiki%2FKementerian_Keuangan_Republik_Indonesia&psig=AOvVaw35C0WmnOTiWmIKm1D2XEHI&ust=1753840940587000&source=images&cd=vfe&opi=89978449&ved=0CBUQjRxqFwoTCPjdouf84I4DFQAAAAAdAAAAABAE')no-repeat center center;
      background-size: contain;
      animation: floaty 3s ease-in-out infinite;
    }

    @keyframes floaty {
      0% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
      100% { transform: translateY(0); }
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      font-family: 'Orbitron', sans-serif;
      font-size: 24px;
      letter-spacing: 1px;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 12px 15px;
      margin: 10px 0;
      border: none;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.1);
      color: #fff;
      font-size: 14px;
    }

    input::placeholder {
      color: rgba(255,255,255,0.7);
    }

    button {
      width: 100%;
      padding: 12px;
      margin-top: 15px;
      border: none;
      border-radius: 10px;
      background: #FFD700;
      color: #002244;
      font-weight: bold;
      font-size: 15px;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(255, 215, 0, 0.4);
      position: relative;
      overflow: hidden;
    }

    button::after {
      content: "";
      position: absolute;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%) scale(0);
      width: 200%;
      height: 200%;
      background: rgba(255, 255, 255, 0.3);
      transition: 0.6s ease;
      border-radius: 50%;
      z-index: 0;
    }

    button:hover {
      background: #ffe033;
      transform: scale(1.03);
      box-shadow: 0 6px 25px rgba(255, 215, 0, 0.6);
    }

    button:active::after {
      transform: translate(-50%, -50%) scale(1);
      opacity: 0;
    }

    .error {
      color: #ff4d4d;
      text-align: center;
      font-size: 14px;
      margin-top: 10px;
    }

    .footer {
      text-align: center;
      font-size: 12px;
      color: #ccc;
      margin-top: 20px;
    }

    .shake {
      animation: shake 0.3s ease-in-out;
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      25% { transform: translateX(-5px); }
      50% { transform: translateX(5px); }
      75% { transform: translateX(-3px); }
    }

    @media screen and (max-width: 500px) {
      .login-box {
        padding: 30px 25px;
        border-radius: 15px;
      }
    }
  </style>
</head>
<body>

  <form class="login-box <?php if(isset($error)) echo 'shake'; ?>" method="POST">
    <div class="mascot"></div>
    <div class="logo"></div>
    <h2>Login Admin</h2>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>

    <button type="submit">Masuk</button>
    <div class="footer">© 2025 KPPN Dumai - Kementerian Keuangan RI</div>
  </form>

</body>
</html>
