<?php
    include("../AUTH/connection.php");
    // Include the necessary libraries for PDF generation
    require('../fpdf/fpdf.php');

    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gastrohub_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Create a new PDF instance
    $pdf = new FPDF();
    $pdf->AddPage();

    // Set the font and font size for the report
    $pdf->SetFont('Arial', 'B', 16);

    // Set the report title
    $pdf->Cell(0, 10, 'User Report', 0, 1, 'C');
    $pdf->Ln(10);

    // Fetch data from the table
    $query = "SELECT * FROM tbl_user ORDER BY last_name";
    $result = $conn->query($query);

    // Check if there are records in the table
    if ($result->num_rows > 0) {
        // Set the font size for the table headers
        $pdf->SetFont('Arial', 'B', 12);

        // Set table headers
        $pdf->Cell(30, 10, 'User ID', 1, 0, 'C');
        $pdf->Cell(60, 10, 'Email', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Full Name', 1, 0, 'C');
        $pdf->Cell(40, 10, 'Clearance Level', 1, 0, 'C');
        $pdf->Ln();

        // Set the font size for the table data
        $pdf->SetFont('Arial', '', 12);

        // Output table data
        while ($row = $result->fetch_assoc()) {
            $fullName = $row['last_name'] . " " . $row['first_name'];

            $pdf->Cell(30, 10, $row['user_id'], 1, 0, 'C');
            $pdf->Cell(60, 10, $row['email'], 1, 0, 'C');
            $pdf->Cell(40, 10, $fullName, 1, 0, 'C');
            $pdf->Cell(40, 10, $row['clearance_level'], 1, 0, 'C');
            $pdf->Ln();
        }
    } else {
        $pdf->Cell(0, 10, 'No records found.', 0, 1, 'C');
    }

    // Output the PDF
    $pdf->Output('user_report.pdf', 'D');

    // Close the database connection
    $conn->close();
?>
