<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .verify-content {
            display: none;
        }

        .show {
            display: block !important;
        }
    </style>
</head>

<body>
    <h1><?= $data["title"] ?></h1>

    <form method="post" action="<?= baseurl(($data["data"] ? "crud.save2" : "crud.save"), ["name" => $data["name"], "id" => $data["data"][$data["id_column"]]]) ?>" autocomplete="off">
        <?php foreach ($data["labelKeys"] as $key) { ?>
            <div class="wrap">
                <?php if ($data["labels"][$key]["isverify"] === true) { ?>
                   <div>
                    <label>Verify</label>
                    <input onchange="showHide(this);" type="checkbox" class="verify">
                   </div>
            <div class="verify-content">
                <label><?= $data["labels"][$key]["title"] ?></label>
                <input type="<?= $data["labels"][$key]["type"] ?>" name="data[<?= $key ?>]" value="">
            </div>
        <?php } else { ?>
            <div>
                <label><?= $data["labels"][$key]["title"] ?></label>
                <input type="<?= $data["labels"][$key]["type"] ?>" name="data[<?= $key ?>]" value="<?= ($data["data"] ? $data["data"][$key] : "") ?>">
            </div>
        <?php } ?>
        </div>
    <?php } ?>
    <button>Save</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        function showHide(e) {
            $(e).parents('.wrap').find('.verify-content').toggleClass('show')
        }
    </script>
</body>

</html>