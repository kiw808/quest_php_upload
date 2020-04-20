<?php
// At least one file is selected
if (!empty($_FILES['files']['name'][0])) {

    // Defining files destination
    $uploadDir = './uploads/';
    // Getting the files array
    $files = $_FILES['files'];
    // Setting the allowed extension
    $allowedTypes = [
        'png',
        'jpeg',
        'jpg',
        'gif',
    ];
    // Setting the maximum file size
    $maxSize = 1000000;

    // Looping for each file name
    foreach ($files['name'] as $key => $fileName) {
        $tmpName = $files['tmp_name'][$key];    // getting the temporary name
        $fileSize = $files['size'][$key];       // getting the size of the file
        $fileError = $files['error'][$key];     // getting the error index of the file
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));   // getting the extension and lowering the cases

        // Checking if the file extension is allowed
        if (!in_array($extension, $allowedTypes)) {
            $error = 'Wrong file type';
        }
        // Checking if the siz of the file is not too big
        if ($fileSize > $maxSize) {
            $error = 'File is too big';
        }
        // If there is no problem, then, upload the file !
        if (!isset($error)) {
            $fileName = uniqid() . '.' . $extension;    // setting a unique file name
            if (move_uploaded_file($tmpName, $uploadDir . $fileName)) {
                echo 'File uploaded !';
            }
            else {
                echo 'Failed to upload ...';
            }
        }
        else {
            echo $error;
        }
    }
}

?>

<div>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="fileUpload">Upload Files</label>
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
        <input type="file" id="fileUpload" name="files[]" multiple>
        <button type="submit" name="Submit" value="Upload">Upload</button>
    </form>
</div>

<?php
// Honestly I didn't quite understand this class but I managed to get it working^^
$it = new FilesystemIterator('./uploads/');

foreach ($it as $fileInfo) {
    ?>
    <figure>
        <img src="./uploads/<?= $fileInfo->getFilename(); ?>" height="100px">
        <figcaption><?= $fileInfo->getFilename(); ?></figcaption>
    </figure>
<?php
}
?>

