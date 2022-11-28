<?php
session_start();
$title = "Login";
$css = "login.css";
include "template/head.php";
include "koneksi.php";
?>
<?php
if ($_GET['sebagai'] == "pengurus") {
    $_SESSION['role'] = "pengurus";
} else if ($_GET['sebagai'] == "anggota") {
    $_SESSION['role'] = "anggota";
} else {
    echo '<script>
            swal("Jangan bikin error kamu!", "", "error").then(function(){
                window.location.assign("index.php");
            });
            </script>';
}
$role = $_SESSION['role'];
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    if ($role == "pengurus") {
        $result = mysqli_query($koneksi, "SELECT id_pengurus, nama, level FROM $role WHERE id_pengurus = '$id'");
    } else {
        $result = mysqli_query($koneksi, "SELECT nim, nama FROM $role WHERE nim = '$id'");
    }

    $row = mysqli_fetch_assoc($result);

    if ($role == "pengurus") {
        if ($key === hash('sha256', $row['id_pengurus'])) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $row['id_pengurus'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['level'] = $row['level'];
        }
    } else {
        if ($key === hash('sha256', $row['nim'])) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $row['nim'];
            $_SESSION['nama'] = $row['nama'];
        }
    }
}

if (isset($_SESSION["login"]) && $_SESSION['role'] == "anggota") {
    header("Location: index.php");
    exit;
} elseif (isset($_SESSION["login"]) && $_SESSION['role'] == "pengurus") {
    header("Location: dashboard.php");
    exit;
}
if (isset($_POST['login'])) {
    $tabel_masuk = $_SESSION['role'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($tabel_masuk == "pengurus") {
        $query = "SELECT * FROM $tabel_masuk WHERE id_pengurus = '$username'";
    } else {
        $query = "SELECT * FROM $tabel_masuk WHERE nim = '$username'";
    }
    $sql = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) === 1) {
        if (password_verify($password, $data['password'])) {
            $_SESSION["login"] = true;
            if ($tabel_masuk == "pengurus") {
                $_SESSION['username'] = $data['id_pengurus'];
                $_SESSION['nama'] = $data['nama'];
                $_SESSION['level'] = $data['level'];
            } else {
                $_SESSION['username'] = $data['nim'];
                $_SESSION['nama'] = $data['nama'];
            }
            if (isset($_POST['remember'])) {
                if ($tabel_masuk == "pengurus") {
                    setcookie('id', $data['id_pengurus'], time() + 60);
                    setcookie('key', hash('sha256', $data['id_pengurus']), time() + 60);
                } else {
                    setcookie('id', $data['nim'], time() + 60);
                    setcookie('key', hash('sha256', $data['nim']), time() + 60);
                }
            }
        }else {
            echo '<script>
                swal("Password Salah!", "", "error").then(function(){
                    window.location.assign("masuk.php?sebagai=' . $tabel_masuk . '");
                });
                </script>';
            exit;
        }
        if ($_SESSION['role'] == "anggota") {
            header('Location: index.php');
            exit;
        } else {
            header('Location: dashboard.php');
            exit;
        }
    } else {
        echo '<script>
            swal("Username Tidak Ditemukan!", "", "error").then(function(){
                window.location.assign("masuk.php?sebagai=' . $tabel_masuk . '");
            });
            </script>';
    }
}
?>
<div id="bg"></div>
<form action="masuk.php" method="post" name="masuk" id="masuk">
    <?php
    if ($_SESSION['role'] == "anggota") {
        echo '<div class="form-field">
                <input type="text" name="username" id="username" placeholder="NIM" required/>
            </div>';
    } else {
        echo '<div class="form-field">
                <input type="text" name="username" id="username" placeholder="ID" required/>
            </div>';
    }

    ?>

    <div class="form-field">
        <input type="password" name="password" id="password" placeholder="Password" required />
    </div>
    <span class="form-field form-inline">
        <input type="checkbox" name="remember" id="remember" />
        <label for="remember" class="label text-white ">Remember Me</label>
    </span>

    <div class="form-field">
        <button class="btn" type="submit" name="login" id="login">Log in</button>
    </div>
</form>

<?php
include "template/foot.php";
?>