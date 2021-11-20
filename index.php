<?php
    require_once('DbHelper.php');

    $error = "";

    $tasks = [];

    try
    {
        $con = DbHelper::GetConnection();

        $query = "SELECT * FROM tasks ORDER BY id DESC";
        $stm = $con->prepare($query);
        $stm->execute();
        $tasks = $stm->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e)
    {
        die("Database error: " . $e->GetMessage());
    }
    catch(Exception $e)
    {
        die("Error: " . $e->GetMessage());
    }
    finally
    {
        unset($con);
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
    <title>Списък със задачи</title>
    <link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/vendor/fontawesome/all.min.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/vendor/jquery-ui/jquery-ui.min.css">
</head>
<body>
<div class="container m-5 p-2 rounded mx-auto bg-light shadow">

    <div class="row m-1 p-4">
        <div class="col">
            <div class="p-1 h1 text-primary text-center mx-auto display-inline-block">
                <i class="fa fa-check bg-primary text-white rounded p-2"></i>
                <u>Списък със задачи</u>
            </div>
        </div>
    </div>

    <div class="row m-1 p-3">
        <div class="col col-11 mx-auto">
            <div class="row rounded p-2 add-todo-wrapper align-items-center justify-content-center">
                <div class="col-auto px-0 mx-0 mr-2">
                    <a href="/create.php" class="btn btn-primary">Добави нова задача</a>
                </div>
            </div>
        </div>
    </div>
    <div class="p-2 mx-4 border-black-25 border-bottom"></div>

    <div class="row mx-1 px-5 pb-3 w-80">
        <div class="col mx-auto">
            <?php
                foreach ($tasks as $task) {
                    ?>
                        <div class="row px-3 align-items-center todo-item rounded border-bottom">
                            <div class="col px-1 m-1 d-flex align-items-center">
                                <div>
                                    <input type="text" class="form-control form-control-lg border-0 edit-todo-input bg-transparent rounded px-3" readonly value="<? echo $task['title']; ?>"/>
                                    <p class="px-3"><?php echo $task['content']; ?></p>
                                </div>
                            </div>
                            <div class="col-auto m-1 p-0 px-3 d-none">
                            </div>
                            <div class="col-auto m-1 p-0 todo-actions">
                                <div class="row d-flex align-items-center justify-content-end">
                                    <a href="/edit.php?id=<?php echo $task['id']; ?>" class="m-0 p-0 px-2 edit-btn action-btn">
                                        <i class="fas fa-pencil-alt text-info btn m-0 p-0"></i>
                                        <span>Редактирай</span>
                                    </a>
                                    <a href="/delete.php?id=<?php echo $task['id']; ?>" class="m-0 p-0 px-2 delete-btn action-btn">
                                        <i class="fas fa-trash-alt text-danger btn m-0 p-0"></i>
                                        <span>Изтрий</span>
                                    </a>
                                </div>
                                <div class="row todo-created-info">
                                    <div class="col-auto d-flex align-items-center pr-2">
                                        <i class="fa fa-info-circle my-2 px-2 text-black-50 btn"></i>
                                        <label class="date-label my-2 text-black-50">
                                            <?php
                                                $date = null;
                                                if ($task['date']) {
                                                    $date .= $task['date'];
                                                }
                                                if ($task['time']) {
                                                    $date .= ' ' . $task['time'];
                                                }

                                                if ($date) {
                                                    echo $date;
                                                } else {
                                                    echo 'Няма зададена дата.';
                                                }
                                            ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                }
            ?>
        </div>
    </div>
</div>
<script src="/assets/vendor/jquery/jquery-3.6.0.min.js"></script>
<script src="/assets/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="/assets/js/main.js"></script>
</body>
</html>
