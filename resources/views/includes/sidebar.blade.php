@php
	$sidebarClass = (!empty($sidebarTransparent)) ? 'sidebar-transparent' : '';
@endphp

<!-- begin #sidebar -->
<div id="sidebar" class="sidebar  {{ $sidebarClass }} ">
	<!-- begin sidebar scrollbar -->
	<div data-scrollbar="true" data-height="100%">
		@if (!$sidebarSearch)
		<!-- begin sidebar user -->
		<ul class="nav">
			<li class="nav-profile" style="background: #218c74">
				<a href="javascript:;" data-toggle="nav-profile">
					@if(Auth::user()->usergroup_id == 1 || Auth::user()->usergroup_id == 3 || Auth::user()->usergroup_id == 6)
						{{-- <div class="cover with-shadow adminbg"></div> --}}
					@else
						{{-- <div class="cover with-shadow userbg"></div> --}}
					@endif
					{{--<div class="cover with-shadow sci"></div>--}}
					<div class="image">
						@if(Auth::user()->usergroup_id == 1 )
							<img src="{{asset('/assets/img/user/user-x.png')}}" alt="" />
						@else
							<img src="{{asset('/assets/img/user/user-0.png')}}" alt="" />
						@endif
					</div>
					<div class="info">
						{{ucwords(strtolower(Auth::user()->name))}}
						<small>{{ucwords(strtolower(Auth::user()->perusahaan))}}</small>
					</div>
				</a>
			</li>
			<li>
				<ul class="nav nav-profile">
				</ul>
			</li>
		</ul>
		<!-- end sidebar user -->
		@endif
		<!-- begin sidebar nav -->
		<ul class="nav">
			@if ($sidebarSearch)
			<li class="nav-search">
        		<input type="text" class="form-control" placeholder="Sidebar menu filter..." data-sidebar-search="true" />
			</li>
			@endif
			<li class="nav-header">Navigation</li>
			@php

				function console_log($output, $with_script_tags = true) {
				    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
				');';
				    if ($with_script_tags) {
				        $js_code = '<script>' . $js_code . '</script>';
				    }
				    echo $js_code;
				}

				//console_log($value); 
				$currentUrl = (Request::path() != '/') ? '/'. Request::path() : '/';
				
				

				function renderSubMenu($value, $currentUrl) {
					//console_log($value); 
					$subMenu = '';
					$GLOBALS['sub_level'] += 1 ;
					$GLOBALS['active'][$GLOBALS['sub_level']] = '';
					$currentLevel = $GLOBALS['sub_level'];
					foreach ($value as $key => $menu) {
						$GLOBALS['subparent_level'] = '';
						
						$subSubMenu = '';
						$hasSub = (!empty($menu['sub_menu'])) ? 'has-sub' : '';
						$hasCaret = (!empty($menu['sub_menu'])) ? '<b class="caret pull-right"></b>' : '';
						$hasTitle = (!empty($menu['title'])) ? $menu['title'] : '';
						$hasHighlight = (!empty($menu['highlight'])) ? '<i class="fa fa-paper-plane text-theme m-l-5"></i>' : '';
						
						if (!empty($menu['sub_menu'])) {
							$subSubMenu .= '<ul class="sub-menu">';
							$subSubMenu .= renderSubMenu($menu['sub_menu'], $currentUrl);
							$subSubMenu .= '</ul>';
						}
						
						$active = ($currentUrl == $menu['url']) ? 'active' : '';
						
						if ($active) {
							$GLOBALS['parent_active'] = true;
							$GLOBALS['active'][$GLOBALS['sub_level'] - 1] = true;
						}
						if (!empty($GLOBALS['active'][$currentLevel])) {
							$active = 'active';
						}

						if($menu['url'] == '#'){
						    $getLink = $menu['url'];
						}else{
						    $getLink = route($menu['url']);
						}

						$subMenu .= '
							<li class="'. $hasSub .' '. $active .'">
								<a href="'. $getLink.'">'. $hasCaret . $hasTitle . $hasHighlight .'</a>
								'. $subSubMenu .'
							</li>
						';
					}
					return $subMenu;
				}

				if(Auth::user()->usergroup_id == 2){					
					if(Auth::user()->registrasi_id == null){
						$configSidebar = config('sidebar.preregistrasi');
					}else{
						$regId = Auth::user()->registrasi_id;
						$getStatusPembayaran = \App\Models\Registrasi::where('id','=',$regId)->first();
						
						
						$configSidebar = config('sidebar.menu2');
						
						
					}
				}elseif(Auth::user()->usergroup_id == 3){					
				    $configSidebar = config('sidebar.menu3');
				}elseif(Auth::user()->usergroup_id == 6){					
					$configSidebar = config('sidebar.menu5');
				}elseif(Auth::user()->usergroup_id == 7){
					$configSidebar = config('sidebar.menu6');
<<<<<<< HEAD
				}elseif(Auth::user()->usergroup_id == 8){
					$configSidebar = config('sidebar.menu7');
				}else{
=======
				}elseif(Auth::user()->usergroup_id == 10){
					$configSidebar = config('sidebar.menu10');
				}
				else{
>>>>>>> e58830a9297231f43e3759efdd968607b1ec63c1
					$configSidebar = config('sidebar.menu');
				}


				foreach ($configSidebar as $key => $menu) {
					$GLOBALS['parent_active'] = '';

					$hasSub = (!empty($menu['sub_menu'])) ? 'has-sub' : '';
					$hasCaret = (!empty($menu['caret'])) ? '<b class="caret"></b>' : '';
					$hasIcon = (!empty($menu['icon'])) ? '<i class="'. $menu['icon'] .'"></i>' : '';
					$hasImg = (!empty($menu['img'])) ? '<div class="icon-img"><img src="'. $menu['img'] .'" /></div>' : '';
					$hasLabel = (!empty($menu['label'])) ? '<span class="label label-theme m-l-5">'. $menu['label'] .'</span>' : '';
					$hasTitle = (!empty($menu['title'])) ? '<span>'. $menu['title'] . $hasLabel .'</span>' : '';
					$hasBadge = (!empty($menu['badge'])) ? '<span class="badge pull-right">'. $menu['badge'] .'</span>' : '';
					
					$subMenu = '';

					if (!empty($menu['sub_menu'])) {
						$GLOBALS['sub_level'] = 0;
						$subMenu .= '<ul class="sub-menu">';
						$subMenu .= renderSubMenu($menu['sub_menu'], $currentUrl);
						$subMenu .= '</ul>';
					}
					$active = ($currentUrl == $menu['url']) ? 'active' : '';

					$active = (empty($active) && !empty($GLOBALS['parent_active'])) ? 'active' : $active;

					if($menu['url'] == '#'){
						    $getLinkA = $menu['url'];
						}else{
						    $getLinkA = route($menu['url']);
						}

					echo '
							<li class="'. $hasSub .' '. $active .'">
								<a href="'.$getLinkA.'">
									'. $hasImg .'
									'. $hasBadge .'
									'. $hasCaret .'
									'. $hasIcon .'
									'. $hasTitle .'
								</a>
								'. $subMenu .'
							</li>
						';

				}
			@endphp
			<!-- begin sidebar minify button -->
			<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify" ><i class="fa fa-angle-double-left"></i></a></li>
			<!-- end sidebar minify button -->
		</ul>
		<!-- end sidebar nav -->
	</div>
	<!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>

