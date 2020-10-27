<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Set variables
$filename = $_GET["filename"];
$file = "../../../" . $filename;
$patient = $_GET["patient"];
$dataURL = substr($_GET["dataURL"],0,-4);
$sessionID = substr($dataURL, 4);
?>

<!-- Modal Window Content -->
<div class="modal-content">
    <div class="modal-top">
        <p id="modal-heading"><?php echo "Data visualization: " . substr($filename,5);?></p>
        <i class="fas fa-times" id="modal-close"></i>
    </div>
    <p id="modal-subheading-exercise"></p>
    <p id="modal-subheading-patient"><?php echo "<b>Patient ID: </b>" . $patient?></p>

    <!-- Create Main Chart -->
    <div id="chart-area">
        <div id="main-chart"></div>
        <div id="chart-area2">
            <div id="secondary-chart"></div>
            <div id="third-chart"></div>
        </div>
    </div>

    <!-- Load Script for CSV parsing -->
    <script src="script/papaparse.min.js"></script>

    <!-- Graph creation -->
    <script>
        // Parse local CSV file
        Papa.parse('<?php echo $file?>', {
            download: true,
            dynamicTyping: true,
            complete: function(results) {
                createGraph(results.data);
            }
        });
        
        //Create graphs for the csv data
        function createGraph(data) {
            var type = 'error';

            //Copy the dataset for multiple usages
            var dataCopy = [[]];
            for (var i = 0; i < data.length; i++){
                dataCopy[i] = data[i].slice();
            }

            //Color code the data for timestamp usage
            var numberOfItems = data.length-1;
            var rainbow = new Rainbow(); 
            rainbow.setNumberRange(1, numberOfItems);
            rainbow.setSpectrum('#c2b6f2', '#3c00b3');
            for (var i = 1; i < data.length; i++){
                var hexCode = "#"+rainbow.colourAt(i);
                data[i][data[i].length] = hexCode;
            }

            // Sort the data for color-coding
            data.sort(sortFunction);
            function sortFunction(a, b) {
                if (a[0] === b[0]) {
                    if (a[1] === b[1]) {
                        return 0;
                    }
                    else {
                        return (a[1] > b[1]) ? -1 : 1;
                    }
                }
                else {
                    return (a[0] < b[0]) ? -1 : 1;
                }
            }


            //Decide which types of graphs to draw depending on the csv-column-count
            //3 columns --> Spiral Drawing Data
            if(data[0].length == 3){
                type = 'spiral';
                $("#modal-subheading-exercise").html('<b>Exercise type: </b>Spiral drawing');
            }
            //5 columns --> Button tapping Data
            else if(data[0].length == 5){
                type = 'tapping';
                $("#modal-subheading-exercise").html('<b>Exercise type: </b>Button tapping');
                $('#chart-area2').hide();
            }

            //Case 1-------------------------------------------------------------: Spiral Drawing Data
            if(type == 'spiral'){

                //Generate arrays for coordinates
                var scatter_x = ['scatter_x'];
                var scatter_y = ['scatter_y'];
                var time = ['time'];
                var hexCode = ['hexCode'];

                //Fill the arrays with coordinates
                for(var i=1; i<data.length; i++){
                    scatter_x.push(data[i][0]);
                    scatter_y.push(data[i][1]);
                    time.push(data[i][2]);
                    hexCode.push(data[i][3]);
                }

                //Draw a scatter plot for X-Y-coordinates (main chart)
                var chart = c3.generate({
                    bindto: '#main-chart',
                    data: {
                        xs: {
                            scatter_y: 'scatter_x',
                        },
                        columns: [
                            scatter_x,
                            scatter_y,
                        ],
                        type: 'scatter',
                        //Color code with timestamp
                        color: function (color, d){
                            return hexCode[d.index+1];
                        },
                    },
                    axis: {
                        x: {
                            min: 0,
                            max: 250,
                            padding: 0,
                            tick: {
                                values: [25,50,75,100,125,150,175,200,225]
                            }
                        },
                        y: {
                            min: 0,
                            max: 250,
                            padding: 0,
                            tick: {
                                values: [25,50,75,100,125,150,175,200,225]
                            }
                        }
                    },
                    size: {
                        height: 440,
                        width: 440,
                    },
                    interaction: {
                        enabled: false
                    },
                    legend: {
                        hide: true
                    }
                });

                //Variables for second chart (Drawing speed) and third chart (irregularity)
                for (var i=2; i < dataCopy.length; i++){
                    //Drawing distance
                    var d = Math.sqrt((Math.pow(dataCopy[i][0]-dataCopy[i-1][0],2)+Math.pow(dataCopy[i][1]-dataCopy[i-1][1],2)));
                    //Drawing speed
                    var v = (d/(dataCopy[i][2]-dataCopy[i-1][2]));
                    dataCopy[i][3]= v;
                    //Irregularity
                    var r = Math.sqrt((Math.pow(dataCopy[i][0]-110,2)+Math.pow(dataCopy[i][1]-125,2)));
                    var r2 = Math.sqrt((Math.pow(dataCopy[i-1][0]-110,2)+Math.pow(dataCopy[i-1][1]-125,2)));
                    dataCopy[i][4]= r-r2;
                }
                
                //Generate arrays for coordinates
                var drawing_speed_time = ['drawing_speed_time'];
                var drawing_speed = ['drawing_speed'];
                var irregularity = ['irregularity'];

                //Fill the arrays with coordinates
                for(var i=2; i<data.length; i++){
                    drawing_speed_time.push(dataCopy[i][2]);
                    drawing_speed.push(dataCopy[i][3]);
                    irregularity.push(dataCopy[i][4]);
                }

                //Create the second chart (line chart)
                var chart = c3.generate({
                    bindto: '#secondary-chart',
                    data: {
                        x: 'drawing_speed_time',
                        columns: [
                            drawing_speed_time,
                            drawing_speed,
                        ]
                    },
                    axis : {
                        x : {
                            label: 'Time in ms',
                            tick: {
                                count: 10,
                                format: d3.format('.0f')
                            }
                        },
                        y: {
                            label: 'Drawing speed in px/s',
                            tick: {
                                format: d3.format('.2f'),
                            }
                        }
                    },
                    point: {
                        r: 0,
                    },
                    interaction: {
                        enabled: false
                    },
                    legend: {
                        hide: true
                    },
                    size: {
                        width: 620
                    }
                });
                //Create the third chart (line chart)
                var chart = c3.generate({
                    bindto: '#third-chart',
                    data: {
                        x: 'drawing_speed_time',
                        columns: [
                            drawing_speed_time,
                            irregularity,
                        ],
                        color: function (color, d) {
                            return '#ffa600';
                        }
                    },
                    axis : {
                        x : {
                            label: 'Time in ms',
                            tick: {
                                count: 10,
                                format: d3.format('.0f')
                            }
                        },
                        y: {
                            label: 'Deviation in px',
                            tick: {
                                format: d3.format('.1f'),
                            }
                        }
                    },
                    point: {
                        r: 0,
                    },
                    interaction: {
                        enabled: false
                    },
                    legend: {
                        hide: true
                    },
                    size: {
                        width: 620
                    }
                });
            }

            //-----------------------------------------------------Case 2: Button Tapping Data
            else if(type == 'tapping'){

                //Generate arrays for coordinates
                var scatter_x = ['scatter_x'];
                var scatter_y = ['scatter_y'];
                var time = ['time'];       
                var button = ['button'];
                var correct = ['correct'];
                var hexCode = ['hexCode'];

                //Fill the arrays with coordinates
                for(var i=1; i<data.length; i++){
                    scatter_x.push(data[i][0]);
                    scatter_y.push(data[i][1]);
                    time.push(data[i][2]);
                    button.push(data[i][3]);
                    correct.push(data[i][4]);
                    hexCode.push(data[i][5]);
                }

                //Draw the chart
                var chart = c3.generate({
                    bindto: '#main-chart',
                    data: {
                        xs: {
                            scatter_y: 'scatter_x',
                        },
                        columns: [
                            scatter_x,
                            scatter_y,
                        ],
                        type: 'scatter',
                        color: function (color, d){
                            if (button[d.index+1] > 0 && correct[d.index+1] == 0){
                                return '#000000';
                            }
                            if (correct[d.index+1] == 1){
                                return '#009e20';
                            }
                            else {
                                return '#d40e00';
                            }
                        },
                    },
                    axis: {
                        x: {
                            min: 0,
                            max: 250,
                            padding: 0,
                            tick: {
                                values: [25,50,75,100,125,150,175,200,225]
                            }
                        },
                        y: {
                            min: 0,
                            max: 100,
                            padding: 0,
                            tick: {
                                values: [25,50,75,100]
                            }
                        }
                    },
                    size: {
                        height: 216,
                        width: 440,
                    },
                    interaction: {
                        enabled: false
                    },
                    legend: {
                        hide: true
                    },
                    padding: {
                        top: 40,
                        // bottom: 132
                    }
                });
                
                //Variables for second chart (Tapping speed)
                dataCopy[1][5]=0;
                for (var i=2; i < dataCopy.length; i++){
                    //Tapping delay
                    var d = dataCopy[i][2]-dataCopy[i-1][2];
                    if (d<0){
                        d=0;
                    }
                    dataCopy[i][5]= d;
                }

                //Array for delay variable
                var delay = ['delay'];
                var time = ['time'];
                var correct = ['correct'];
                for(var i=1; i<dataCopy.length; i++){
                    delay.push(dataCopy[i][5]);
                    time.push(dataCopy[i][2]);
                    correct.push(dataCopy[i][4]);
                }

                //Create the second chart (line chart)
                var chart = c3.generate({
                    bindto: '#secondary-chart',
                    data: {
                        x: 'time',
                        columns: [
                            time,
                            delay,
                        ],
                        color: function (color, d){
                            if (correct[d.index+1]==1){
                                return '#009e20';
                            }
                            else{
                                return '#d40e00';
                            }
                        },
                    },
                    axis : {
                        x : {
                            label: 'Duration in ms',
                            tick: {
                                count: 10,
                                format: d3.format('.0f')
                            }
                        },
                        y: {
                            label: 'Tapping delay in ms',
                            tick: {
                                format: d3.format('.0f'),
                            }
                        }
                    },
                    point: {
                        r: 3,
                    },
                    interaction: {
                        enabled: false
                    },
                    legend: {
                        hide: true
                    },
                    size: {
                        width: 620
                    }
                });
            }
        }
    </script>





    <!-------------------------- Annotation functionality --------------------------------------->
    <div id="annotation">
        <p id="annotation-heading">Comments</p>

        <?php
        include "../../dbconnect.php";
        
        // Check for existing notes for the session data
        $notes = mysqli_query($conn,"SELECT note.note, user.username, note.noteID, user.userID
        FROM note
        INNER JOIN user ON note.User_IDmed = user.userID
        INNER JOIN test_session ON test_session.test_SessionID = note.Test_Session_IDtest_session 
        WHERE test_session.dataURL = '$dataURL'");
        
        // Display existing notes, if there are any
        if ($notes->num_rows > 0) {
            ?>
            <ul id="notes">
            <?php
            while($row = $notes->fetch_assoc()) {
                ?>
                <li>
                    <label id="user"><?php echo $row["username"]?></label>
                    <p class="note"><?php echo $row["note"]?></p>
                    <?php if($row["userID"]==$_SESSION["userid"]){
                        ?>
                        <form action="includes/content/modal/delete_comment.php" id="del-comment" style="display: contents;">
                            <button type="submit" id="delete-comment">
                                <input type="hidden" name="note-id" value="<?php echo $row["noteID"]?>"/>
                                <i class="las la-trash-alt"></i>
                            </button>
                            <input type="hidden" name="patient" value="<?php echo $patient?>"/>
                            <input type="hidden" name="filename" value="<?php echo $filename?>"/>
                            <input type="hidden" name="dataURL" value="<?php echo $dataURL?>"/>
                        </form>
                        <?php
                    }
                    ?>
                </li>
            <?php
            }
            ?>
            </ul>
        <?php
        }else{
            ?><p id="annotation-heading" style="font-weight:400;margin-top: 0;padding-top: 0;font-size: 1em;">No comments yet.</p>
        <?php
        }
        ?>  	

        <!-- Input field for adding comments/annotations -->
        <form action="includes/content/modal/add_comment.php" id="comment">
            <input type="text" id="comment-form" name="comment-form" placeholder="Comment..." minlength="2" required>
            <input type="hidden" name="session-id" value="<?php echo $sessionID?>"/>
            <input type="hidden" name="patient" value="<?php echo $patient?>"/>
            <input type="hidden" name="filename" value="<?php echo $filename?>"/>
            <input type="hidden" name="dataURL" value="<?php echo $dataURL?>"/>
            <button type="submit" id="submit-comment">
                <i class="las la-paper-plane"></i>
            </button>
        </form>
        </div>
</div>