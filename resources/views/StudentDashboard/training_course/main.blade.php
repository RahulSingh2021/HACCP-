@include('StudentDashboard.top1')
<header>
	<div class="container ">
		<div class="row align-items-center">
			<div class="col-md-12 col-lg-8">
				<h2 class="mycourseheaing mb-3">Adobe Illustrator CC - Essentials Training Course</h2>
				<p class="completesolutiontitle mb-3">Lear Adobe Illustrator CC - Essentials Training Course Create a distinctive resume to stand out from the crowd. Finding the perfect,</p>
				<div class="d-flex align-items-center flex-wrap mb-4">
					<div class="d-flex align-items-center me-3 createdby">
						<img src="{{asset('student_dashboard/assets/img/usericon.png')}}" alt="img">
						<span>Created by <b>John Doe</b></span>
					</div>

					<div class="d-flex align-items-center me-3 includedcr">
						<i class="fa fa-user-o" aria-hidden="true"></i>
						<span>4 Courses included</span>
					</div>

					<div class="d-flex align-items-center me-3 coursrating">
						<span><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></span>
						<span>(0 Reviews)</span>
					</div>

				</div>
			</div>
			<div class="col-md-12 col-lg-4"></div>


		</div>
	</div>
</header>
<div class="container ">
	<div class="row completesolusec">


		<div class="col-md-12 col-lg-8">
			<div class="coursetab">
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link active" id="Overview-tab" data-bs-toggle="tab" data-bs-target="#Overview" type="button" role="tab" aria-controls="Overview" aria-selected="true"><i class="fa fa-bookmark"></i> Overview</button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="Curriculum-tab" data-bs-toggle="tab" data-bs-target="#Curriculum" type="button" role="tab" aria-controls="Curriculum" aria-selected="false"><i class="fa fa-file-o" aria-hidden="true"></i> Curriculum </button>
					</li>
					<li class="nav-item" role="presentation">
						<button class="nav-link" id="Instructor-tab" data-bs-toggle="tab" data-bs-target="#Instructor" type="button" role="tab" aria-controls="Instructor" aria-selected="false"><i class="fa fa-user-o" aria-hidden="true"></i> Instructor</button>
					</li>

					<li class="nav-item" role="presentation">
						<button class="nav-link" id="Review-tab" data-bs-toggle="tab" data-bs-target="#Review" type="button" role="tab" aria-controls="Review" aria-selected="false"> <i class="fa fa-comment-o" aria-hidden="true"></i> Review</button>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="Overview" role="tabpanel" aria-labelledby="Overview-tab">
						<h2 class="mb-2">Course description</h2>
						<p>What is WordPress (WP) used for, and why is it so popular? We’ll outline its advantages so you can figure out if you're interested in learning how to use this tool.</p>
						<p>What is WordPress (WP) used for, and why is it so popular? We’ll outline its advantages so you can figure out if you're interested in learning how to use this tool.</p>
						<p>What is WordPress (WP) used for, and why is it so popular? We’ll outline its advantages so you can figure out if you're interested in learning how to use this tool.</p>
						<p>What is WordPress (WP) used for, and why is it so popular? We’ll outline its advantages so you can figure out if you're interested in learning how to use this tool.</p>
						<p>What is WordPress (WP) used for, and why is it so popular? We’ll outline its advantages so you can figure out if you're interested in learning how to use this tool.</p>
						<p>What is WordPress (WP) used for, and why is it so popular? We’ll outline its advantages so you can figure out if you're interested in learning how to use this tool.</p>


						<h2 class="mb-2">What will i learn?</h2>
						<p>What is WordPress (WP) used for, and why is it so popular? We’ll outline its advantages so you can figure out if you're interested in learning how to use this tool.</p>
						<p>What is WordPress (WP) used for, and why is it so popular? We’ll outline its advantages so you can figure out if you're interested in learning how to use this tool.</p>
						<p>What is WordPress (WP) used for, and why is it so popular? We’ll outline its advantages so you can figure out if you're interested in learning how to use this tool.</p>

					</div>

					<div class="tab-pane fade" id="Curriculum" role="tabpanel" aria-labelledby="Curriculum-tab">
						<div class="accordion" id="accordionExample">
						<div class="accordion-item">
							<button class="accordion-button d-flex flex-wrap justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
									<div class="curriculum">
										Adobe Certified Instructor & Adobe Certified Expert
									</div>
									<div class="d-flex align-items-center crriculesson">
										<span class="me-2">3 Lessons </span>
										<span>00:46:37 Hours </span>
									</div>
								</button>
							<div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="heading1" data-bs-parent="#accordionExample">
								<div class="accordion-body">
									<div class="curriculumVideolist">
										<ul>
											<li><a href="#">Color in the Impossible Triangle <span>00:02:39</span></a></li>
											<li><a href="#">Color in the Impossible Triangle <span>00:02:39</span></a></li>
											<li><a href="#">Color in the Impossible Triangle <span>00:02:39</span></a></li>
											<li><a href="#">Color in the Impossible Triangle <span>00:02:39</span></a></li>
											<li><a href="#">Color in the Impossible Triangle <span>00:02:39</span></a></li>
											<li><a href="#">Color in the Impossible Triangle <span>00:02:39</span></a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="accordion-item">
								<button class="accordion-button d-flex flex-wrap justify-content-between collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
									<div class="curriculum">
										Adobe Certified Instructor & Adobe Certified Expert
									</div>
									<div class="d-flex align-items-center crriculesson">
										<span class="me-2">3 Lessons </span>
										<span>00:46:37 Hours </span>
									</div>
								</button>
							<div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#accordionExample">
								<div class="accordion-body">
									<div class="curriculumVideolist">
										<ul>
											<li><a href="#">Color in the Impossible Triangle <span>00:02:39</span></a></li>
											<li><a href="#">Color in the Impossible Triangle <span>00:02:39</span></a></li>
											<li><a href="#">Color in the Impossible Triangle <span>00:02:39</span></a></li>
											<li><a href="#">Color in the Impossible Triangle <span>00:02:39</span></a></li>
											<li><a href="#">Color in the Impossible Triangle <span>00:02:39</span></a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="accordion-item">
								<button class="accordion-button d-flex flex-wrap justify-content-between collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
									<div class="curriculum">
										Adobe Certified Instructor & Adobe Certified Expert
									</div>
									<div class="d-flex align-items-center crriculesson">
										<span class="me-2">3 Lessons </span>
										<span>00:46:37 Hours </span>
									</div>
								</button>
							<div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordionExample">
								<div class="accordion-body">
									<div class="curriculumVideolist">
										<ul>
											<li><a href="#">Color in the Impossible Triangle <span>00:02:39</span></a></li>
											<li><a href="#">Color in the Impossible Triangle <span>00:02:39</span></a></li>
											<li><a href="#">Color in the Impossible Triangle <span>00:02:39</span></a></li>
											<li><a href="#">Color in the Impossible Triangle <span>00:02:39</span></a></li>
											<li><a href="#">Color in the Impossible Triangle <span>00:02:39</span></a></li>
											<li><a href="#">Color in the Impossible Triangle <span>00:02:39</span></a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>

						<div class="accordion-item">
								<button class="accordion-button d-flex flex-wrap justify-content-between collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
									<div class="curriculum">
										Adobe Certified Instructor & Adobe Certified Expert
									</div>
									<div class="d-flex align-items-center crriculesson">
										<span class="me-2">3 Lessons </span>
										<span>00:46:37 Hours </span>
									</div>
								</button>
							<div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordionExample">
								<div class="accordion-body">
									<div class="curriculumVideolist">
										<ul>
											<li><a href="#">Color in the Impossible Triangle <span>00:02:39</span></a></li>
											<li><a href="#">Color in the Impossible Triangle <span>00:02:39</span></a></li>
											<li><a href="#">Color in the Impossible Triangle <span>00:02:39</span></a></li>
											<li><a href="#">Color in the Impossible Triangle <span>00:02:39</span></a></li>
											<li><a href="#">Color in the Impossible Triangle <span>00:02:39</span></a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>





					</div>
					</div>


					<div class="tab-pane fade" id="Instructor" role="tabpanel" aria-labelledby="Instructor-tab">
						<div class="d-flex  flex-wrap">
							<div class="instructorimg">
								<img src="{{asset('student_dashboard/assets/img/instructure.jpg')}}" class="img-fluid">
							</div>

							<div class="instructordetail">
								<h2>John Doe</h2>
								<p>Adobe Certified Instructor & Adobe Certified Expert</p>
								<p>Sharing is who I am, and teaching is where I am at my best Sharing is who I am, and teaching is where I am at my best</p>
								<div class="d-flex align-items-center">
									<ul class="social">
										<li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
										<li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
										<li><a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
									</ul>
									<a href="#" class="viewprofile">View profile</a>
								</div>
							</div>
						</div>
					</div>

					<div class="tab-pane fade" id="Review" role="tabpanel" aria-labelledby="Review-tab">
						<div class="d-flex flex-wrap align-items-start">
							<div class="reviewleft">
								<h3>Signe Thompson</h3>
								<div class="date">26-Jan-2024</div>
								<h4>5</h4>
								<div class="d-flex justify-content-center reviewrating">
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
									<i class="fa fa-star" aria-hidden="true"></i>
								</div>

							</div>
							<div class="reviewcnt">
								<p>Adobe Certified Instructor & Adobe Certified Expert Sharing is who I am, and teaching is where I am at my best Sharing is who I am, and teaching is where I am at my best</p>
							</div>

						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="col-md-12 col-lg-4">
			<div class="p-2 boxshdow  buysubscription courstypelist">
				<div class="subscriptionimg"><img src="{{asset('student_dashboard/assets/img/bookimg.jpg')}}" alt="img" class="img-fluid"></div>
				<div class="p-2 p-md-4">
					<div class="d-flex align-items-center justify-content-between">
						<span class="subscriptionPrice">$70 <span>$18.99</span></span>
						<a href="#"><i class="fa fa-compress" aria-hidden="true"></i></a>
					</div>
					<ul>
						<li class="d-flex">
							<span><i class="fa fa-list-alt" aria-hidden="true"></i> Leactures</span>
							<span>10</span>
						</li>

						<li class="d-flex">
							<span><i class="fa fa-file-text-o" aria-hidden="true"></i> Quizzes</span>
							<span>2</span>
						</li>

						<li class="d-flex">
							<span><i class="fa fa-empire" aria-hidden="true"></i>Skill level</span>
							<span>Advanced</span>
						</li>

						<li class="d-flex">
							<span><i class="fa fa-calendar-o" aria-hidden="true"></i> Expiry period</span>
							<span>Lifetime</span>
						</li>

						<li class="d-flex">
							<span><i class="fa fa-graduation-cap" aria-hidden="true"></i> Certificate</span>
							<span>yes</span>
						</li>


					</ul>
					<div class="text-center mt-1">
						<a href="#" class="buysubscriptionbtn mb-3"><i class="fa fa-play-circle-o" aria-hidden="true"></i> Start now</a>

						<a href="#" class="buysubscriptionbtn mb-3"><i class="fa fa-gift" aria-hidden="true"></i> Gift Someone else</a>

						<a href="#" class="buysubscriptionbtn"><i class="fa fa-share-alt" aria-hidden="true"></i> Share and earn</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@include('StudentDashboard.bottom1')
