<?php 
include 'db.php'; 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Complaint</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="flex w-3/4 bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Left Section: Complaint Form -->
        <div class="w-1/2 p-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Submit a Complaint</h2>
            <form action="submit_complaint.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                <label class="block font-semibold text-gray-700">Category:</label>
                <select name="category" required class="w-full p-2 border rounded">
                <option value="Hostel">Hostel</option>
                    <option value="Classroom">Classroom</option>
                    <option value="WiFi">WiFi</option>
                    <option value="Food">Food</option>
                    <option value="Faculty">Faculty</option>
                    <option value="Student Behavior">Student Behavior</option>
                    <option value="Library">Library</option>
                    <option value="Security">Security</option>
                    <option value="Exam System">Exam System</option>
                    <option value="Sports Facilities">Sports Facilities</option>
                    <option value="Transport">Transport</option>
                    <option value="Administration">Administration</option>
                    <option value="Medical Services">Medical Services</option>
                    <option value="Ragging">Ragging</option>
                    <option value="Fees and Payments">Fees and Payments</option>
                    <option value="Cleanliness">Cleanliness</option>
                    <option value="IT Services">IT Services</option>
                    <option value="Counseling Services">Counseling Services</option>
                    <option value="Infrastructure">Infrastructure</option>
                    <option value="Canteen Hygiene">Canteen Hygiene</option>
                    <option value="Water Supply">Water Supply</option>
                    <option value="Electricity">Electricity</option>
                    <option value="Discipline Issues">Discipline Issues</option>
                    <option value="Hostel Warden">Hostel Warden</option>
                    <option value="Noise Disturbance">Noise Disturbance</option>
                    <option value="Unfair Grading">Unfair Grading</option>
                    <option value="Lab Equipment">Lab Equipment</option>
                    <option value="Parking Issues">Parking Issues</option>
                    <option value="Course Structure">Course Structure</option>
                    <option value="Exam Schedule">Exam Schedule</option>
                    <option value="Research Support">Research Support</option>
                    <option value="Cultural Activities">Cultural Activities</option>
                    <option value="Internship Support">Internship Support</option>
                    <option value="Career Services">Career Services</option>
                    <option value="Scholarship Assistance">Scholarship Assistance</option>
                    <option value="Equality & Discrimination">Equality & Discrimination</option>
                    <option value="Lost & Found">Lost & Found</option>
                    <option value="WiFi Speed">WiFi Speed</option>
                    <option value="Furniture Issues">Furniture Issues</option>
                    <option value="Billing Errors">Billing Errors</option>
                    <option value="Faculty Unavailability">Faculty Unavailability</option>
                    <option value="Branch Coordination">Branch Coordination</option>
                    <option value="Extracurricular Support">Extracurricular Support</option>
                    <option value="Laboratory Management">Laboratory Management</option>
                    <option value="Plagiarism & Academic Honesty">Plagiarism & Academic Honesty</option>
                </select>

                <label class="block font-semibold text-gray-700">Description:</label>
                <textarea name="description" rows="4" required class="w-full p-2 border rounded"></textarea>

                <label class="block font-semibold text-gray-700">Upload Image (Optional):</label>
                <input type="file" name="image" class="w-full p-2 border rounded">

                <button type="submit" name="submit" class="w-full p-3 bg-blue-600 text-white rounded hover:bg-blue-700">Submit Complaint</button>
            </form>
            <button class="w-full p-3 mt-3 bg-green-600 text-white rounded hover:bg-green-700" onclick="window.location.href='complaints.php'">View Complaints</button>
        </div>
        
        <!-- Right Section: Image -->
        <div class="w-1/2">
            <img src="carosel/complainBG.avif" alt="Complaint Background" class="h-full w-full object-cover">
        </div>
    </div>
</body>
</html>
