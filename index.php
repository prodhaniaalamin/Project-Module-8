<?php
include 'db.php';

// Fetch all photos from the database
$result = $conn->query("SELECT * FROM photos ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Gallery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.min.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Photo Gallery</h1>
        </header>

        <section>
            <h2>Upload Photo</h2>
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <fieldset>
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" placeholder="Enter photo title" required>

                    <label for="image">Choose Image</label>
                    <input type="file" id="image" name="image" accept=".jpg, .jpeg, .png, .webp, .gif" required>

                    <button type="submit" class="button-primary">Upload</button>
                </fieldset>
            </form>
        </section>

        <section>
            <h2>Gallery</h2>
            <?php if ($result->num_rows > 0): ?>
                <div class="row">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="column column-25">
                            <img src="<?php echo $row['image_path']; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" style="width: 100%; height: auto;">
                            <p><?php echo htmlspecialchars($row['title']); ?></p>
                            <form action="delete.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="button">Delete</button>
                            </form>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>No photos uploaded yet.</p>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>
