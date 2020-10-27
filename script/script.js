$(document).ready(function() {
    //------------- Page Height ----------------
    $('.content-container').css("min-height", function(){ 
        return $(this).height($(window).height() - $('.header').height() - $('#nav-bar').height() - 60);
    });

    //------------- Login Menu -------------
    //Patient-Login
    $("#btn-patient").click(function(){
        $(".btn-card-content").fadeOut(150, function(){
            $("#note-small").hide();
            $("#note").text("Sign in as a patient");
            $(".btn-group").html('<a href="login.php?provider=google" class="btn-google"><i class="fab fa-google" aria-hidden="true"></i>&nbsp;Login with Google</a><p class="question">Not a patient? <a href="">Go back</a></p>');;
            $(".btn-card-content").fadeIn(150);
        });
    });
    
    //Physican-Login
    $("#btn-physician").click(function(){
        $(".btn-card-content").fadeOut(150, function(){
            $("#note-small").hide();
            $("#note").text("Sign in as a physician");
            $(".btn-group").html('<a href="login.php?provider=twitter" class="btn-twitter"><i class="fab fa-twitter" aria-hidden="true"></i>&nbsp;Login with Twitter</a><p class="question">Not a physician? <a href="">Go back</a></p>');;
            $(".btn-card-content").fadeIn(150);
        });    
    });

    //Researcher-Login
    $("#btn-researcher").click(function(){
        $(".btn-card-content").fadeOut(150, function(){
            $("#note-small").hide();
            $("#note").text("Sign in as a researcher");
            $(".btn-group").html('<a href="login.php?provider=github" class="btn-github"><i class="fab fa-github" aria-hidden="true"></i>&nbsp;Login with Github</a><p class="question">Not a researcher? <a href="">Go back</a></p>');;
            $(".btn-card-content").fadeIn(150);
        });   
    });

    //------------- Load default content -------------
    if($("#nav-patients-researcher").hasClass('nav-active')){
        $(".content-container").load('includes/content/content_researcher.php');
    }
    // if($("#nav-patients-physician-visualization").hasClass('nav-active')){
    //     $(".content-container").load('includes/content/physician_visualization.php');
    // }
    if($("#nav-patients-physician").hasClass('nav-active')){
         $(".content-container").load('includes/content/content_physician.php');
    }
    if($("#nav-data").hasClass('nav-active')){
        $(".content-container").load('includes/content/content_patient.php');
    }

    //------------- Navbar Content Switch -------------
    //RSS feed button
    $("#nav-rss-news").click(function(){
        $(this).addClass('nav-active');
        $(this).siblings('button').removeClass('nav-active');
        $(".content-container").load('includes/content/rss_feed.php');
    });
    // Profile page button
    $("#nav-profile").click(function(){
        $(this).addClass('nav-active');
        $(this).siblings('button').removeClass('nav-active');
        $(".content-container").load('includes/content/profile.php');
    });
    // Patients (Researcher) page button
    $("#nav-patients-researcher").click(function(){
        $(this).addClass('nav-active');
        $(this).siblings('button').removeClass('nav-active');
        $(".content-container").load('includes/content/content_researcher.php');
    });
    // Patients (Physician) page button
    $("#nav-patients-physician").click(function(){
        $(this).addClass('nav-active');
        $(this).siblings('button').removeClass('nav-active');
        $(".content-container").load('includes/content/content_physician.php');
    });
    // Patient data button
    $("#nav-data").click(function(){
        $(this).addClass('nav-active');
        $(this).siblings('button').removeClass('nav-active');
        $(".content-container").load('includes/content/content_patient.php'); 
    });
    // Patient videos button
    $("#nav-videos").click(function(){
        $(this).addClass('nav-active');
        $(this).siblings('button').removeClass('nav-active');
        $(".content-container").load('includes/content/videos.php');
    });

    //--------------- Modal Windows -----------------
    // Open Modal window for CSV files
    $(document).on('click', '.btn-data-view', function(){
        $filename = $(this).parent().siblings('.item-name').text();
        $filename = "data/"+$filename;
        $('#data-modal').fadeIn(200);
        $('#data-modal').load('includes/content/modal/modal_csv.php?filename='+$filename);
    });

    // Close Modal window
    $(document).on('click', '#modal-close', function(){
        $('#data-modal').fadeOut(200);
    });

    //--------------- Download the CSV file -----------------
    $(document).on('click', '.btn-data-download', function(e){
        e.preventDefault();
        $filename = $(this).parent().siblings('.item-name').text();
        $filename = "data/"+$filename;
        window.location.href = $filename;
    });

    //Open Modal Window for Visualization
    $(document).on('click', '.btn-data-visualize', function(){
        $dataURL = $(this).parent().siblings('.item-name').text();
        $filename = "data/"+$dataURL;
        $patient = $(this).val();
        $('#data-modal').fadeIn(200);
        $('#data-modal').load('includes/content/modal/modal_visualize.php?patient='+$patient+'&filename='+$filename+'&dataURL='+$dataURL);
    });

    //Open Patient View (Physician)
    $(document).on('click', '.btn-therapy-view', function(){
        $patient = $(this).val();
        $(".content-container").load('includes/content/patient_view.php?patient='+$patient);
    });

    //Open Patient View (Researcher) - Map 
    $(document).on('click', '.activity-link', function(){
        $patient = $(this).val();
        $(".content-container").load('includes/content/patient_view_researcher.php?patient='+$patient);
    });
    //Open Patient View (Researcher) - Table 
    $(document).on('click', '.btn-therapy-view-researcher', function(){
        $patient = $(this).val();
        $(".content-container").load('includes/content/patient_view_researcher.php?patient='+$patient);
    });

    //Return from Patient activity view to patient overview (depending on the role)
    $(document).on('click', '#btn-return-overview', function(){
        $roletype = $(this).val();
        console.log($roletype);
        if($roletype=="2"){
            $(".content-container").load('includes/content/content_physician.php');
        }
        else if($roletype == "3"){
            $(".content-container").load('includes/content/content_researcher.php');
        }
    });

});

