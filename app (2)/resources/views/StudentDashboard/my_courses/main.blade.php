@include('StudentDashboard.top')
<div class="userprofilebox">
    <button class="sidebarbtn"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
        <path d="M33.4167 18.333H6.58333C5.70888 18.333 5 19.0419 5 19.9163V20.083C5 20.9575 5.70888 21.6663 6.58333 21.6663H33.4167C34.2911 21.6663 35 20.9575 35 20.083V19.9163C35 19.0419 34.2911 18.333 33.4167 18.333Z" fill="black"/>
        <path d="M33.4167 26.667H6.58333C5.70888 26.667 5 27.3759 5 28.2503V28.417C5 29.2914 5.70888 30.0003 6.58333 30.0003H33.4167C34.2911 30.0003 35 29.2914 35 28.417V28.2503C35 27.3759 34.2911 26.667 33.4167 26.667Z" fill="black"/>
        <path d="M33.4167 10H6.58333C5.70888 10 5 10.7089 5 11.5833V11.75C5 12.6245 5.70888 13.3333 6.58333 13.3333H33.4167C34.2911 13.3333 35 12.6245 35 11.75V11.5833C35 10.7089 34.2911 10 33.4167 10Z" fill="black"/>
    </svg></button>

    <div class="profiledatesec">
        <div class="dashboardcntbox">
            <h2 class="dashmainheading">Courses</h2>
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="boxshdow courselist d-flex flex-wrap align-items-start justify-content-between p-4 mb-4">
                        <div class="coursevideoimg"><img src="{{asset('student_dashboard/assets/img/courseimg.jpg')}}" alt="img" class="img-fluid"></div>
                        <div class="ps-4 abtcourse">
                            <div class=" d-flex align-items-center justify-content-between">
                                <h2  class="pe-3 mb-2">Adobe Illustrator CC-Essentials Training Course</h2>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="mb-2 lectures">
                                <ul class="d-flex">
                                    <li><a href="#"><i class="fa fa-play-circle" aria-hidden="true"></i> Lectures</a></li>
                                    <li><a href="#"><i class="fa fa-question-circle" aria-hidden="true"></i> Quizzes</a></li>
                                    <li><a href="#"><i class="fa fa-clock-o" aria-hidden="true"></i> 01:31:12 Hours</a></li>
                                </ul>
                            </div>
                            <div class="progress">
                                <span style="width: 30%"></span>
                            </div>
                            <div class="upcoming">
                                <p>Upcoming live class <span>08:00 PM, 14 Dec 2024</span></p>
                            </div>

                            <div class="mt-2 d-flex justify-content-between align-items-center flex-wrap">
                                <div class="d-flex justify-content-between flex-wrap w-50">
                                    <div class="d-flex align-items-center flex-wrap">
                                        <img class="userphoto" src="{{asset('student_dashboard/assets/img/userimg.jpg')}}">
                                        <span class="videouploadby">John Doe</span>
                                        <span class="rating">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <h4 class="expiryperiod mt-2">Expiry period - <span>LIFETIME ACCESS</span></h4>
                                </div>
                                <a href="#" class="startnowbtn"><i class="fa fa-play-circle-o" aria-hidden="true"></i> Start now</a>
                            </div>

                        </div>
                    </div>
                    <div class="boxshdow courselist d-flex flex-wrap align-items-start justify-content-between p-4 mb-4">
                        <div class="coursevideoimg"><img src="{{asset('student_dashboard/assets/img/courseimg.jpg')}}" alt="img" class="img-fluid"></div>
                        <div class="ps-4 abtcourse">
                            <div class=" d-flex align-items-center justify-content-between">
                                <h2  class="pe-3 mb-2">Adobe Illustrator CC-Essentials Training Course</h2>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="mb-2 lectures">
                                <ul class="d-flex">
                                    <li><a href="#"><i class="fa fa-play-circle" aria-hidden="true"></i> Lectures</a></li>
                                    <li><a href="#"><i class="fa fa-question-circle" aria-hidden="true"></i> Quizzes</a></li>
                                    <li><a href="#"><i class="fa fa-clock-o" aria-hidden="true"></i> 01:31:12 Hours</a></li>
                                </ul>
                            </div>
                            <div class="progress">
                                <span style="width: 30%"></span>
                            </div>
                            <div class="upcoming">
                                <p>Upcoming live class <span>08:00 PM, 14 Dec 2024</span></p>
                            </div>

                            <div class="mt-2 d-flex justify-content-between align-items-center flex-wrap">
                                <div class="d-flex justify-content-between flex-wrap w-50">
                                    <div class="d-flex align-items-center flex-wrap">
                                        <img class="userphoto" src="{{asset('student_dashboard/assets/img/userimg.jpg')}}">
                                        <span class="videouploadby">John Doe</span>
                                        <span class="rating">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <h4 class="expiryperiod mt-2">Expiry period - <span>LIFETIME ACCESS</span></h4>
                                </div>
                                <a href="#" class="startnowbtn"><i class="fa fa-play-circle-o" aria-hidden="true"></i> Start now</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('StudentDashboard.bottom')
