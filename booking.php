<?php
include('header.php');
// include('connect.php');

$product_id = isset($_GET['product_id']) ? htmlspecialchars($_GET['product_id']) : '';

// Fetch the price, security cost, and image of the selected dress from the database
$sql = "SELECT productname, price, original_price, image FROM inventory WHERE product_id='$product_id'";
$result = $con->query($sql); // Execute the query directly

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['productname'];
    $pricePerDay = $row['price'];
    $securityCost = $row['original_price'];
    $image = $row['image'];
} else {
    // Handle no results found
    $pricePerDay = 0;
    $securityCost = 0;
    $image = '';
}

// Close any connections or resources as needed
$result->free();
// $con->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Dress</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="rent.css">
    <style>
        .booking-form {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .dress-image {
            display: flex;
            justify-content: center;
            align-items: center;
            max-width: 100%;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="login-nav"></div>
    <div class="booking-form">
        <h2 style="text-align:center">Book a Dress</h2>
        <img src="admin/<?php echo htmlspecialchars($image); ?>" alt="" width="300px" height="350px" class="dress-image" style="margin-left:30%">
        <form action="process_booking.php" method="POST"  style="margin-left:10%">
            <div class="mb-3">
                <label for="dress" class="form-label">Dress</label>
                <input type="text" class="form-control" id="dress" name="name" value="<?php echo htmlspecialchars($name); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="pricePerDay" class="form-label">Per Day Rent</label>
                <input type="text" class="form-control" id="pricePerDay" value="Rs <?php echo number_format($pricePerDay, 2); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="securityCost" class="form-label">Security Cost</label>
                <input type="text" class="form-control" id="securityCost" value="Rs <?php echo number_format($securityCost, 2); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="startDate" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="startDate" name="startDate" required>
            </div>
            <div class="mb-3">
                <label for="endDate" class="form-label">End Date</label>
                <input type="date" class="form-control" id="endDate" name="endDate" required>
            </div>
            <div class="mb-3">
                <label for="totalRentCost" class="form-label">Total Rent Cost</label>
                <input type="text" class="form-control" id="totalRentCost" name="totalRentCost" readonly>
            </div>
            <div class="mb-3">
                <label for="totalCost" class="form-label">Total to Pay (Security + Rent)</label>
                <input type="text" class="form-control" id="totalCost" name="totalCost" readonly>
            </div>
            <!-- <div class="mb-3">
                <label for="finalCost" class="form-label">Final Cost (After Returning the Dress)</label>
                <input type="text" class="form-control" id="finalCost" name="finalCost" readonly>
            </div> -->
            <div class="mb-3">
                <label for="refundAmount" class="form-label">Refund Amount</label>
                <input type="text" class="form-control" id="refundAmount" name="refundAmount" readonly>
            </div>

            <input type="hidden" id="hiddenPricePerDay" value="<?php echo $pricePerDay; ?>">
            <input type="hidden" id="hiddenSecurityCost" value="<?php echo $securityCost; ?>">
            <input type="hidden" id="quantity" name="quantity" value="1">
            <button type="submit" class="btn">Submit Booking</button>
        </form>

        <p class="mt-5">*The product should be returned on the end date without any damages and packed properly. Our deliveryman will check the order before confirming pickup.</p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('startDate');
            const endDateInput = document.getElementById('endDate');
            const totalRentCostInput = document.getElementById('totalRentCost');
            const totalCostInput = document.getElementById('totalCost');
            const finalCostInput = document.getElementById('finalCost');
            const refundAmountInput = document.getElementById('refundAmount');
            const pricePerDayInput = parseFloat(document.getElementById('hiddenPricePerDay').value);
            const securityCostInput = parseFloat(document.getElementById('hiddenSecurityCost').value);

            function calculateCosts() {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);

                if (startDate && endDate && startDate <= endDate) {
                    const timeDiff = endDate.getTime() - startDate.getTime();
                    const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1; // Including the end date
                    const totalRentCost = daysDiff * pricePerDayInput;
                    totalRentCostInput.value = `Rs.${totalRentCost.toFixed(2)}`;

                    const totalCost = totalRentCost + securityCostInput;
                    totalCostInput.value = `Rs.${totalCost.toFixed(2)}`;

                    const refundAmount = securityCostInput; // Refund amount is the security deposit
                    refundAmountInput.value = `Rs.${refundAmount.toFixed(2)}`;

                    const finalCost = securityCostInput - totalRentCost;
                    finalCostInput.value = `Rs.${finalCost.toFixed(2)}`;
                } else {
                    totalRentCostInput.value = '';
                    totalCostInput.value = '';
                    refundAmountInput.value = '';
                    finalCostInput.value = '';
                }
            }

            startDateInput.addEventListener('change', calculateCosts);
            endDateInput.addEventListener('change', calculateCosts);
        });
    </script>
</body>

</html>
<?php
include('footer.php');
$con->close();
?>
