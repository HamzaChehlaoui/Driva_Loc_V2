<?php
include('conn.php');

$database = new Database();
$conn = $database->getConnection();

$query = "SELECT * FROM `reservation`";
$stmt = $conn->prepare($query);
$stmt->execute();
$reservation = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking Display Page</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white font-sans leading-tight tracking-tight">

  <!-- Navbar -->
  <nav class="bg-black text-white py-4 shadow-lg">
    <div class="max-w-7xl mx-auto px-4">
      <div class="flex justify-between items-center">
        <div class="text-2xl font-bold">
          <a href="#">MyWebsite</a>
        </div>
        <div>
          <ul class="flex space-x-6">
            <li><a href="user.php" class="hover:bg-gray-700 px-4 py-2 rounded transition">Home</a></li>
            <li><a href="showcare.php" class="hover:bg-gray-700 px-4 py-2 rounded transition">Explore Cars</a></li>
            <li><a href="showReserv.php" class="hover:bg-gray-700 px-4 py-2 rounded transition">Reservation</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <div class="max-w-6xl mx-auto my-12 p-6 bg-gray-800 rounded-lg shadow-lg">
    <h2 class="text-3xl font-bold text-center text-indigo-400 mb-6">Booking Details</h2>

    <div class="overflow-x-auto bg-gray-900 rounded-lg">
      <table class="min-w-full table-auto text-left">
        <thead>
          <tr class="bg-gray-700 text-white">
            <th class="px-6 py-3 text-sm font-medium">Reservation Date</th>
            <th class="px-6 py-3 text-sm font-medium">Reservation Return Date</th>
            <th class="px-6 py-3 text-sm font-medium">Status</th>
            <th class="px-6 py-3 text-sm font-medium">Pickup Location</th>
            <th class="px-6 py-3 text-sm font-medium">Return Location</th>
            <th class="px-6 py-3 text-sm font-medium">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($reservation) > 0) { ?>
            <?php foreach ($reservation as $row) { ?>
              <tr class="border-b border-gray-600">
                <td class="px-6 py-4 text-sm text-gray-400"><?= $row['dateDebut']; ?></td>
                <td class="px-6 py-4 text-sm text-gray-400"><?= $row['dateFin']; ?></td>
                <td class="px-6 py-4 text-sm text-gray-400"><?= $row['statut']; ?></td>
                <td class="px-6 py-4 text-sm text-gray-400"><?= $row['Pickup_Location']; ?></td>
                <td class="px-6 py-4 text-sm text-gray-400"><?= $row['Return_Location']; ?></td>
                <td class="px-6 py-4 text-sm text-gray-400">
                  <!-- Edit Link -->
                  <a href="editReserv.php?id=<?= $row['idReservation']; ?>" class="text-yellow-400 hover:text-yellow-500 transition">Edit</a> |
                  <?php if ($row['statut'] == 'acceptable') { ?>
                    <form action="rateCar.php" method="POST" class="inline">
                      <input type="hidden" name="reservation_id" value="<?= $row['idReservation']; ?>">
                      <input type="hidden" name="car_id" value="<?= $row['vehiculeId']; ?>"> <!-- Assuming car_id is available -->
                      <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>"> <!-- Assuming user_id is available in session -->

                      <div class="mt-2">
                        <label for="rating" class="text-gray-400">Rate the Car: </label><br>
                        <input type="number" name="rating" min="1" max="5" class="bg-gray-700 text-white p-2 rounded" required>
                      </div>
                      <div class="mt-2">
                        <label for="comment" class="text-gray-400">Comment: </label><br>
                        <textarea name="comment" class="bg-gray-700 text-white p-2 rounded" rows="3" placeholder="Write your comments here..."></textarea>
                      </div>
                      <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded mt-4">Submit Rating</button>
                    </form>
                  <?php } ?>
                </td>
              </tr>
            <?php } ?>
          <?php } else { ?>
            <tr><td colspan="6" class="text-center text-gray-400">No reservations found.</td></tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Footer Section -->
  <footer class="bg-gray-800 py-6 mt-16 text-center">
    <p>&copy; 2024 Car Rental. All rights reserved.</p>
  </footer>

</body>
</html>
