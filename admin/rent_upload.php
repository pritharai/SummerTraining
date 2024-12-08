<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload Dress</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        .btn-custom {
            background-color: #FEAE6F;
            color: white;
        }

        .btn-custom:hover {
            background-color: #e0945c;
        }
    </style>
</head>

<body>
    <div class="login-nav"></div>
    <div class="form-container">
        <h2 class="text-center">Upload Dress</h2>
        <form id="uploadDressForm" method="POST" enctype="multipart/form-data" action="upload_rent.php">
            <div class="mb-3">
                <label for="dressName" class="form-label">Dress Name</label>
                <input type="text" class="form-control" id="dressName" name="productname" required>
            </div>
            <div class="mb-3">
                <label for="dressDescription" class="form-label">Description</label>
                <textarea class="form-control" id="dressDescription" name="description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="dressPrice" class="form-label">Price per day</label>
                <input type="number" class="form-control" id="dressPrice" name="price" required>
            </div>
            <div class="mb-3">
                <label for="dressImage" class="form-label">Image</label>
                <input type="file" class="form-control" id="dressImage" name="image" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-custom w-100">Upload</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
