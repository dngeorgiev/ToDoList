<?php
    if ($_GET['id'] != '') {
        require_once('DbHelper.php');

        $error = '';

        $id = $id ?? intval($_GET['id']);

        if (!$id) {
            header('Location: index.php');
            exit;
        };

        try
        {
            $con = DbHelper::GetConnection();

            $query = 'SELECT * FROM tasks WHERE id=:id';
            $stm = $con->prepare($query);
            $stm->bindParam('id', $id);

            if ($stm->execute()) {
                $deleteQuery = 'DELETE FROM tasks WHERE id=:id';
                $deleteStatement = $con->prepare($deleteQuery);
                $deleteStatement->bindParam('id', $id);
                $deleteStatement->execute();
            }
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
            header('Location: index.php');
            exit;
        }
    }
?>