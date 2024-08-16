<?php
/**
 * Konfigurasi Menu WP Nglorok
*/

class Wp_Nglorok_Menu {

	public static function menu(){
		$menu = [
			'dashboard' => [
				'title'		=> 'Dashboard',
				'icon'		=> 'icon-grid',
				'role'		=> '',
			],
			'billing' 	=> [
				'title'		=> 'Billing',
				'icon'		=> 'icon-layout',
				'role'		=> ['billing'],
			],
			'bill_dataweb' 	=> [
				'title'		=> 'Database Web',
				'icon'		=> 'fa fa-database',
				'role'		=> ['billing'],
			],
			'lead_data' => [
				'title'		=> 'Lead Data',
				'icon'		=> 'icon-bar-graph',
				'role'		=> ['billing'],
				'submenu'	=> [
					'lead'	=> [
						'title'		=> 'Lead Order',
						'role'		=> ['billing'],
					],
					'leadads' => [
						'title'		=> 'Lead Iklan',
						'role'		=> ['billing'],
					],
				],
			],
			'iklan_google_per_bulan' => [
				'title'		=> 'Iklan Google per bulan',
				'icon'		=> 'fa fa-tags',
				'role'		=> ['billing'],
			],
			'form'	=> [
				'title'		=> 'Jumlah Kirim Form',
				'icon'		=> 'fa fa-file-text-o',
				'role'		=> ['billing'],
			],
			'rincian_transaksi_grafik' => [
				'title'		=> 'Rincian Transaksi Grafik',
				'icon'		=> 'fa fa-bar-chart-o',
				'role'		=> ['billing'],
			],
			'#' => [
				'title'		=> 'Menu Lain',
				'icon'		=> 'fa fa-info-circle',
				'role'		=> ['billing'],
				'submenu'	=> [
					'kelola_cuti' => [
						'title'		=> 'Data Cuti',
						'role'		=> ['billing'],
					],
					'jurnal' => [
						'title'		=> 'Jurnal',
						'role'		=> ['billing'],
					],
					'pemakaian_themes' => [
						'title'		=> 'Pemakaian Themes',
						'role'		=> ['billing'],
					],
					'peningkatan_order_cs' => [
						'title'		=> 'Peningkatan Order CS',
						'role'		=> ['billing'],
					],
				],
			],
			
		];
		return $menu;
	}

	public static function display(){
		$permalink	= get_the_permalink();
		$site		= get_site_url();

		echo '<ul class="nav">';
			foreach( self::menu() as $slug => $menu):

				$id_menu = $slug!=='#'?$slug:uniqid();

				// link
				$link = $site.'/'.$slug.'/';
				if(isset($menu['submenu']) && !empty($menu['submenu'])){
					$link = '#sub-'.$id_menu;
				} elseif ($slug=='dashboard'){
					$link = $site.'/';
				}

				//attribut link
				$attr_link		= [];
				$attr_link[]	= 'href='.$link;
				if(isset($menu['submenu']) && !empty($menu['submenu'])){
					$attr_link[]	= 'data-bs-toggle="collapse"';
					$attr_link[]	= 'aria-expanded="false"';
					$attr_link[]	= 'aria-controls="#sub-'.$slug.'"';
				}

				//Parent Menu
				$parent_active = ($link==$permalink)?'active':'';
				echo '<li class="nav-item '.$parent_active.'">';
					echo '<a class="nav-link" '.implode(" ",$attr_link).'>';

						echo $menu['icon']?'<i class="'.$menu['icon'].' menu-icon"></i>':'';
						echo '<div class="menu-title">';
							echo $menu['title'];
						echo '</div>';

						if(isset($menu['submenu']) && !empty($menu['submenu'])){
							echo '<i class="menu-arrow"></i>';
						}
					echo '</a>';

					//submenu
					if(isset($menu['submenu']) && !empty($menu['submenu'])){

						echo '<div class="collapse" id="sub-'.$id_menu.'">';
							echo '<ul class="nav flex-column sub-menu ps-4">';
								foreach( $menu['submenu'] as $sub_slug => $sub_menu):
									$sub_link = $site.'/'.$sub_slug;
									echo '<li class="nav-item">';
										echo '<a class="nav-link" href="'.$sub_link.'">';
											echo '<div class="menu-title">';
												echo $sub_menu['title'];
											echo '</div>';
										echo '</a>';
									echo '</li>';
								endforeach;
							echo '</ul>';
						echo '</div>';
						
					}

				echo '</li>';

			endforeach;
		echo '</ul>';

	}

}