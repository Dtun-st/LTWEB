<?php 
    $mysqli= new mysqli('localhost','root','','ban_hang_dien_tu');
    $username1='admin';
    $password1='admin123';
    $email1="admin@gmail.com";
    $role1='admin';

    //chọn bcrypt vì nó an toàn, mỗi lần mã hóa là 1 salt ngẫu nhiên
    $hashedPassword1 = password_hash($password1, PASSWORD_BCRYPT);

    $username2='user1';
    $password2='123456';
    $email2="user1@gmail.com";
    $role2='user';

    $hashedPassword2 = password_hash($password2, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssss", $username1, $hashedPassword1, $email1, $role1);
    $stmt->execute();


    $stmt->bind_param("ssss", $username2, $hashedPassword2, $email2, $role2);
    $stmt->execute();

?>