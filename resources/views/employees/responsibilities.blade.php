@extends('employees.home.app')

@section('topnav')
<header class="dash-toolbar">


    <div class="main-label" >
        Responsibilities
    </div>
    <div class="tools">
     
     @include('notification')
     @include('employees.home.header')
    </div>
</header>
@endsection

@section('main')

<div class="responsibility">
    <div class="title" style="font-family: Cairo;
    font-size: 24px;
    font-weight: 700;
    letter-spacing: 0px;
    text-align: left;
    ">
        UI/UX Designer responsibilities include:

</div>
    <div class="res_body" style="font-family: Cairo;
    font-size: 20px;
    font-weight: 400;
    line-height: 24px;
    letter-spacing: 0em;
    text-align: left;
    ">
    Gathering and evaluating user requirements, in collaboration with product managers and engineers </br>
     Illustrating design ideas using storyboards, process flows and sitemaps</br>
     Designing graphic user interface elements, like menus, tabs and widgets</br>
     UI/UX Designer job description</br></br>

     Job brief</br>
     We are looking for a UI/UX Designer to turn our software into easy-to-use products for our clients.</br></br>

     UI/UX Designer responsibilities include gathering user requirements, designing graphic elements and building navigation</br>
     components. To be successful in this role, you should have experience with design software and wireframe tools. If you also</br>
     have a portfolio of professional design projects that includes work with web/mobile applications, we’d like to meet you.</br></br>

     Ultimately, you’ll create both functional and appealing features that address our clients’ needs and help us grow our customer base.</br></br>

     Responsibilities</br>
     Gather and evaluate user requirements in collaboration with product managers and engineers</br>
     Illustrate design ideas using storyboards, process flows and sitemaps</br>
     Design graphic user interface elements, like menus, tabs and widgets</br>
     Build page navigation buttons and search fields</br>
     Develop UI mockups and prototypes that clearly illustrate how sites function and look like</br>
     Create original graphic designs (e.g. images, sketches and tables)</br>
     Prepare and present rough drafts to internal teams and key stakeholders</br>
     Identify and troubleshoot UX problems (e.g. responsiveness)</br>

     <!--Conduct layout adjustments based on user feedback Adhere to style standards on fonts, colors and images
        Requirements and skills Proven work experience as a UI/UX Designer or similar role
        Portfolio of design projects Knowledge of wireframe tools (e.g. Wireframe.cc and InVision)
        Up-to-date knowledge of design software like Adobe Illustrator and Photoshop Team spirit;
        strong communication skills to collaborate with various stakeholders
         Good time-management skills BSc in Design, Computer Science or relevant field

     -->
    </div>
</div>

@endsection
