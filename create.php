<?php
require_once('DbHelper.php');

$error = '';

if(isset($_POST['submit'])) {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? null;
    $date = $_POST['date'] ?? null;
    $time = $_POST['time'] ?? null;

    if (!$title) {
        $error .= '<p>Заглавието е задължително поле!</p>';
    } else if(strlen($title) > 200) {
        $error .= '<p>Заглавието надвишава 200 символа!</p>';
    }

    if(!$error)
    {
        $con = null;

        try {
            $con = DbHelper::GetConnection();

            $query = 'INSERT INTO tasks(`title`, `content`, `date`, `time`) VALUES(:title, :content, :date, :time)';
            $stm = $con->prepare($query);
            $stm->bindParam(':title', $title);
            $stm->bindParam(':content', $content);
            $stm->bindParam(':date', $date, !$date ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $stm->bindParam(':time', $time, !$time ? PDO::PARAM_NULL : PDO::PARAM_STR);
            $stm->execute();

            $id = $con->lastInsertId();
            header('Location: edit.php?id=' . $id);
        } catch(PDOException $e) {
            die('Грешка с базата данни: ' . $e->GetMessage());
        } catch(Exception $e) {
            die('Грешка: ' . $e->GetMessage());
        } finally {
            unset($con);
            exit;
        }
    }
}
?>

<!doctype html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="author" content="Dani Nedelchev Georgiev">
    <title>Добавяне на нова задача</title>
    <link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/vendor/fontawesome/all.min.css">
    <link rel="stylesheet" href="/assets/vendor/jquery-ui/jquery-ui.min.css">
    <link rel="stylesheet" href="/assets/vendor/jquery-timepicker/jquery.timepicker.min.css">
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>
<div class="container m-5 p-2 rounded mx-auto bg-light shadow">

    <div class="row m-1 p-4">
        <div class="col">
            <div class="p-1 h1 text-primary text-center mx-auto display-inline-block">
                <i class="fa fa-check bg-primary text-white rounded p-2"></i>
                <u>Добавяне на нова задача</u>
            </div>
        </div>
    </div>

    <div class="row m-1 p-3">
        <div class="col col-11 mx-auto">
            <div class="row rounded p-2 add-todo-wrapper align-items-center justify-content-center">
                <div class="col-auto px-0 mx-0 mr-2">
                    <a href="/index.php" class="btn btn-primary">Списък със задачи</a>
                </div>
            </div>
        </div>
    </div>
    <div class="p-2 mx-4 border-black-25 border-bottom"></div>

    <div class="row mx-1 px-5 pb-3 w-80 mt-4">
        <div class="col mx-auto">
            <?php
                if($error)
                {
                    echo $error;
                }
            ?>
            <form action="create.php" method="POST">
                <div class="form-group">
                    <label for="title">Заглавие *</label>
                    <input type="text"
                           id="title"
                           class="form-control"
                           name="title"
                           placeholder="Заглавие"
                           value="<?php echo $title ?: ''; ?>"
                           required>
                </div>

                <div class="form-group mt-3">
                    <label for="content">Съдържание</label>
                    <textarea id="content"
                              class="form-control"
                              placeholder="Съдържание"
                              name="content"><?php echo $content ?: ''; ?></textarea>
                </div>

                <div class="form-group mt-3">
                    <label for="date">Дата</label>
                    <input id="date"
                           class="form-control"
                           placeholder="Дата"
                           name="date"
                           value="<?php echo $date ?: ''; ?>"
                           autocomplete="off"
                    />
                </div>

                <div class="form-group mt-3">
                    <label for="time">Час</label>
                    <input id="time"
                           class="form-control"
                           placeholder="Час"
                           name="time"
                           value="<?php echo $time ?: ''; ?>"
                           autocomplete="off"
                    />
                </div>

                <div class="form-group mt-5">
                    <button type="submit" name="submit" class="btn btn-primary">Добавяне</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="/assets/vendor/jquery/jquery-3.6.0.min.js"></script>
<script src="/assets/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="/assets/vendor/jquery-timepicker/jquery.timepicker.min.js"></script>
<script src="/assets/js/main.js"></script>
</body>
</html>
