<?php 
session_start(); 
include "../connection.php"; 

$question_no = ""; 
$question = ""; 
$opt1 = ""; 
$opt2 = ""; 
$opt3 = ""; 
$opt4 = ""; 
$answer = ""; 
$count = 0; 
$ans = ""; 
$queno = $_GET["questionno"]; 

if (isset($_SESSION["answer"][$queno])) { 
    $ans = $_SESSION["answer"][$queno]; 
} 

$res = mysqli_query($link, "SELECT * FROM questions WHERE category='$_SESSION[exam_category]' AND question_no=$_GET[questionno]"); 
$count = mysqli_num_rows($res); 

if ($count == 0) { 
    echo "over"; 
} else { 
    while ($row = mysqli_fetch_array($res)) { 
        $question_no = $row["question_no"]; 
        $question = $row["question"]; 
        $opt1 = $row["opt1"]; 
        $opt2 = $row["opt2"]; 
        $opt3 = $row["opt3"]; 
        $opt4 = $row["opt4"]; 
        $question_type = $row["question_type"]; 
    } 
?>
<br>
<table>
    <tr>
        <td style="font-weight: bold; font-size: 18px; padding-left: 5px" colspan="2">
            <?php echo "( " . $question_no . " ) " . $question; ?>
        </td>
    </tr>
</table>

<?php if ($question_type == 'multiple_choice') { ?>
    <table style="margin-left: 10px">
        <tr>
            <td>
                <input type="radio" name="r1" id="opt1" value="<?php echo $opt1; ?>" onclick="radioclick(this.value, <?php echo $question_no; ?>)" <?php if ($ans == $opt1) { echo "checked"; } ?>>
            </td>
            <td style="padding-left: 10px"><?php echo $opt1; ?></td>
        </tr>
        <tr>
            <td>
                <input type="radio" name="r1" id="opt2" value="<?php echo $opt2; ?>" onclick="radioclick(this.value, <?php echo $question_no; ?>)" <?php if ($ans == $opt2) { echo "checked"; } ?>>
            </td>
            <td style="padding-left: 10px"><?php echo $opt2; ?></td>
        </tr>
        <tr>
            <td>
                <input type="radio" name="r1" id="opt3" value="<?php echo $opt3; ?>" onclick="radioclick(this.value, <?php echo $question_no; ?>)" <?php if ($ans == $opt3) { echo "checked"; } ?>>
            </td>
            <td style="padding-left: 10px"><?php echo $opt3; ?></td>
        </tr>
        <tr>
            <td>
                <input type="radio" name="r1" id="opt4" value="<?php echo $opt4; ?>" onclick="radioclick(this.value, <?php echo $question_no; ?>)" <?php if ($ans == $opt4) { echo "checked"; } ?>>
            </td>
            <td style="padding-left: 10px"><?php echo $opt4; ?></td>
        </tr>
    </table>
<?php } else if ($question_type == 'true_false') { ?>
    <table style="margin-left: 10px">
        <tr>
            <td>
                <input type="radio" name="r1" id="true_option" value="True" onclick="radioclick(this.value, <?php echo $question_no; ?>)" <?php if ($ans == "True") { echo "checked"; } ?>>
            </td>
            <td style="padding-left: 10px">True</td>
        </tr>
        <tr>
            <td>
                <input type="radio" name="r1" id="false_option" value="False" onclick="radioclick(this.value, <?php echo $question_no; ?>)" <?php if ($ans == "False") { echo "checked"; } ?>>
            </td>
            <td style="padding-left: 10px">False</td>
        </tr>
    </table>
<?php } else if ($question_type == 'text_answer') { ?>
    <table style="margin-left: 10px; width: 100%;">
        <tr>
            <td style="padding-left: 10px">
                <textarea id="text_answer" name="text_answer" rows="5" cols="50" placeholder="Type your answer here..."><?php echo htmlspecialchars($ans); ?></textarea>
            </td>
        </tr>
        <tr>
            <td style="padding-left: 10px; padding-top: 10px;">
                <button type="button" onclick="submitTextAnswer(<?php echo $question_no; ?>)" class="submit-btn" style="padding: 5px 15px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">Submit Answer</button>
                <span id="save-status" style="margin-left: 10px; font-size: 14px;"></span>
            </td>
        </tr>
    </table>
<?php } ?>

<script>
    
// Function to submit text answers explicitly
function submitTextAnswer(questionNo) {
    const textAnswer = document.getElementById('text_answer').value;

    // Show an alert with the text typed in the textbox
    alert("You typed: " + textAnswer);

    // Proceed with saving the answer
    saveAnswer(textAnswer, questionNo);
}


// Function to handle radio button selections
function radioclick(value, questionNo) {
    saveAnswer(value, questionNo);
}

// Common function to save answers to both session and database
function saveAnswer(answer, questionNo) {
    // Show "Saving..." message for text answers
    const statusElement = document.getElementById('save-status');
    if (statusElement) {
        statusElement.textContent = "Saving...";
        statusElement.style.color = "#FF9800";
    }
    
    // Log what we're trying to save
    console.log('Saving answer:', answer, 'for question:', questionNo);
    
    // Send data to server
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_answer.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
    xhr.onload = function() {
        console.log('XHR response received:', this.responseText);
        
        try {
            const response = JSON.parse(this.responseText);
            
            if (response.status === 'success') {
                console.log('Answer saved successfully for question ' + questionNo);
                
                // Update status message on success for text answers
                if (statusElement) {
                    statusElement.textContent = "Answer saved!";
                    statusElement.style.color = "green";
                    
                    // Clear the status message after 3 seconds
                    setTimeout(() => {
                        statusElement.textContent = "";
                    }, 3000);
                }
            } else {
                console.error('Error saving answer:', response.message);
                
                // Show error message for text answers
                if (statusElement) {
                    statusElement.textContent = "Error: " + response.message;
                    statusElement.style.color = "red";
                }
            }
        } catch (e) {
            console.error('Invalid JSON response:', this.responseText);
            
            if (statusElement) {
                statusElement.textContent = "Error: Invalid server response";
                statusElement.style.color = "red";
            }
        }
    };
    
    xhr.onerror = function() {
        console.error('Request failed');
        if (statusElement) {
            statusElement.textContent = "Network error. Please try again.";
            statusElement.style.color = "red";
        }
    };
    
    // Prepare the data to send
    const data = 'questionNo=' + encodeURIComponent(questionNo) + '&answer=' + encodeURIComponent(answer);
    console.log('Sending data:', data);
    
    // Send the request
    xhr.send(data);
}

</script>
<?php } ?>