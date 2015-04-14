<div class = "navbar navbar-inverse navbar-fixed-top"> <!-- navbar-default for white -->
			<div class = "container">
				
				<a href = "#"  class = "navbar-brand">Tech Site</a>
				
				<button class = "navbar-toggle" data-toggle = "collapse" data-target = ".navHeaderCollapse">
					<span class = "icon-bar"></span>
					<span class = "icon-bar"></span>
					<span class = "icon-bar"></span>
				</button>

				<div class = "collapse navbar-collapse navHeaderCollapse">
				
					<ul class = "nav navbar-nav navbar-right">
						<li class = "active"><a href = "#">Home</a></li>
						
							<li><a href = "#">Notification
									<span class = "badge">@if(Session::has('count')) {{Session::get('count')}} @endif</span>
								</a>
							</li>
						
						<li><a href = "#">Blog</a></li>
						<li><a href = "#">Forum</a></li>
						<li><a href = "#">Events</a></li>
						<li><a href = "#">Gallery</a></li>
						<li class = "dropdown">
							<a href = "#" class = "dropdown-toggle" data-toggle="dropdown">Social Media <b class = "caret"></b></a>
							<ul class = "dropdown-menu">
								<li><a href = "#">Twitter</a></li>
								<li><a href = "#">Facebook</a></li>
								<li><a href = "#">Google+</a></li>
								<li><a href = "#">Instagram</a></li>
							</ul>
						</li>
						<li><a href = "#">About</a></li>
						<li><a href = "#contact" data-toggle="modal">Contact</a></li>
					</ul>
				

				</div>

			</div>
		</div><!-- this is end of top navbar -->