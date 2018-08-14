<?php
namespace Autosupplyph\Topmenu\Observer;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Data\Tree\Node;
use Magento\Framework\Event\ObserverInterface;
class Topmenu implements ObserverInterface
{
	/**
	* @param EventObserver $observer
	* @return $this
	*/
	public function execute(EventObserver $observer)
	{
		/** @var \Magento\Framework\Data\Tree\Node $menu */
		$menu = $observer->getMenu();
		$tree = $menu->getTree();
		
		$home = [
			'name' => __('HOME'),
			'id' => 'menu-home',
			'url' => '/',
			'is_active' => 0
		];
		
		$aboutus = [
			'name' => __('ABOUT US'),
			'id' => 'menu-aboutus',
			'url' => '/aboutus',
			'is_active' => 0
		];

			/*------------------ About us child ------------------*/
				$whoweare = [
					'name' => __('Who We Are'),
					'id' => 'aboutus-whoweare',
					'url' => '/aboutus#whoweare',
					'is_active' => 0
				];
				
				$whatweoffer = [
					'name' => __('What We Offer'),
					'id' => 'aboutus-whatweoffer',
					'url' => '/aboutus#whatweoffer',
					'is_active' => 0
				];
				
				$mission = [
					'name' => __('Mission & Vision'),
					'id' => 'aboutus-mission',
					'url' => '/aboutus#missionvision',
					'is_active' => 0
				];
				
				$careers = [
					'name' => __('Careers'),
					'id' => 'aboutus-careers',
					'url' => '/inquiry/index/careers?success=',
					'is_active' => 0
				];
				
				$contactus = [
					'name' => __('Contact Us'),
					'id' => 'aboutus-contactus',
					'url' => '/inquiry/index/contactus?success=',
					'is_active' => 0
				];
			/*----------------------------------------------------*/
		
		$parts = [
			'name' => __('SHOP PARTS'),
			'id' => 'menu-shopparts',
			'url' => '/parts.html',
			'is_active' => 0
		];
		
			/*------------------ Shop Parts child ------------------*/
				$bodypartsmirrors = [
					'name' => __('Auto Body Parts & Mirrors'),
					'id' => 'shopparts-autobodypartsmirrors',
					'url' => '/parts/auto-body-parts-mirrors.html',
					'is_active' => 0
				];
				
				$breakssuspensionsteering = [
					'name' => __('Breaks, Suspension & Steering'),
					'id' => 'shopparts-breaksuspensionsteering',
					'url' => '/parts/break-suspension-steering.html',
					'is_active' => 0
				];
				
				$enginedrivetrain = [
					'name' => __('Engine & Drivetrain'),
					'id' => 'shopparts-enginedrivetrain',
					'url' => '/parts/engine-drivetrain.html',
					'is_active' => 0
				];
				
				$headlightslighting = [
					'name' => __('Headlights & Lighting'),
					'id' => 'shopparts-headlightslighting',
					'url' => '/parts/headlights-lighting.html',
					'is_active' => 0
				];
				
				$interioraccessories = [
					'name' => __('Interior Accessories'),
					'id' => 'shopparts-interioraccessories',
					'url' => '/parts/interior-accessories.html',
					'is_active' => 0
				];
				$exterioraccessories = [
					'name' => __('Exterior Accessories'),
					'id' => 'shopparts-exterioraccessories',
					'url' => '/parts/exterior-accessories.html',
					'is_active' => 0
				];
				
				$wheelstires = [
					'name' => __('Wheels & TIres'),
					'id' => 'shopparts-wheelstires',
					'url' => '/parts/wheels-tires.html',
					'is_active' => 0
				];
				
				$toolsgarage = [
					'name' => __('Tools & Garage'),
					'id' => 'shopparts-toolsgarage',
					'url' => '/parts/tools-garage.html',
					'is_active' => 0
				];
			/*----------------------------------------------------*/
		
		$cars = [
			'name' => __('SHOP CARS'),
			'id' => 'menu-shopcars',
			'url' => '/cars.html',
			'is_active' => 0
		];

				/*------------------ Cars child ------------------*/
				$carss = [
					'name' => __('Cars'),
					'id' => 'cars-cars',
					'url' => '/cars/cars.html',
					'is_active' => 0
				];
				
				$suv = [
					'name' => __('SUV'),
					'id' => 'cars-suv',
					'url' => '/cars/suv.html',
					'is_active' => 0
				];
				
				$pickup = [
					'name' => __('Pickup'),
					'id' => 'cars-pickup',
					'url' => '/cars/pickup.html',
					'is_active' => 0
				];
				
				$vans = [
					'name' => __('Vans'),
					'id' => 'cars-vans',
					'url' => '/cars/vans.html',
					'is_active' => 0
				];
				/*----------------------------------------------------*/
		
		$merchandise = [
			'name' => __('SHOP MERCHANDISE'),
			'id' => 'menu-shopmerchandise',
			'url' => '/general-merchandise.html',
			'is_active' => 0
		];

				/*------------------ Merchandise child ------------------*/
				$apparel = [
					'name' => __('Apparel'),
					'id' => 'merchandise-apparel',
					'url' => '/general-merchandise/apparel.html',
					'is_active' => 0
				];
				
				$autobodytools = [
					'name' => __('Auto Body Tools'),
					'id' => 'merchandise-autobodytools',
					'url' => '/general-merchandise/auto-body-tools.html',
					'is_active' => 0
				];
				
				$carcare = [
					'name' => __('Car Care'),
					'id' => 'merchandise-carcare',
					'url' => '/general-merchandise/car-care.html',
					'is_active' => 0
				];
				
				$codereaders = [
					'name' => __('Code Readers, Scan Tools & Components'),
					'id' => 'merchandise-codereaders',
					'url' => '/general-merchandise/code-readers-scan-tools-components.html',
					'is_active' => 0
				];
				
				$garageaccessories = [
					'name' => __('Garage Accessories'),
					'id' => 'merchandise-garageaccessories',
					'url' => '/general-merchandise/garage-accessories.html',
					'is_active' => 0
				];
				$jacksliftsstands = [
					'name' => __('Jacks, Lifts & Stands'),
					'id' => 'merchandise-jacksliftsstands',
					'url' => '/general-merchandise/jacks-lifts-stands.html',
					'is_active' => 0
				];
				
				$mobileelectronics = [
					'name' => __('Mobile Electronics'),
					'id' => 'merchandise-mobileelectronics',
					'url' => '/general-merchandise/mobile-electronics.html',
					'is_active' => 0
				];
				
				$repairmanuals = [
					'name' => __('Repair Manuals, Videos & Software'),
					'id' => 'merchandise-repairmanuals',
					'url' => '/general-merchandise/repair-manuals-videos-software.html',
					'is_active' => 0
				];

				$tirewheelcare = [
					'name' => __('Tire & Wheel Care'),
					'id' => 'merchandise-tirewheelcare',
					'url' => '/general-merchandise/tire-wheel-care.html',
					'is_active' => 0
				];

				$toolboxesaccessories = [
					'name' => __('Tool Boxes & Accessories'),
					'id' => 'merchandise-toolboxesaccessories',
					'url' => '/general-merchandise/tool-boxes-accessories.html',
					'is_active' => 0
				];
							
				$tools = [
					'name' => __('Tools'),
					'id' => 'merchandise-tools',
					'url' => '/general-merchandise/tools.html',
					'is_active' => 0
				];
			/*----------------------------------------------------*/
		
		$services = [
			'name' => __('SERVICES'),
			'id' => 'menu-services',
			'url' => '/services',
			'is_active' => 0
		];


			/*------------------ Services child ------------------*/
				$insurance = [
					'name' => __('Insurance'),
					'id' => 'services-insurance',
					'url' => '/insurance',
					'is_active' => 0
				];
				
				$carmaintenance = [
					'name' => __('Car Maintenance'),
					'id' => 'services-carmaintenance',
					'url' => '/car-maintenance',
					'is_active' => 0
				];
				
				$partsinstallation = [
					'name' => __('Parts Installation'),
					'id' => 'services-partsinstallation',
					'url' => '/parts-installation',
					'is_active' => 0
				];
				
				$rentalsandleasing = [
					'name' => __('Rentals and Leasing'),
					'id' => 'services-rentalsandleasing',
					'url' => '/car-rentals',
					'is_active' => 0
				];

				$carcareanddetailing = [
					'name' => __('Car Care and Detailing'),
					'id' => 'services-carcareanddetailing',
					'url' => '/car-care-and-detailing',
					'is_active' => 0
				];
				
				$partsfinder = [
					'name' => __('Parts Finder'),
					'id' => 'services-partsfinder',
					'url' => '/parts-finder',
					'is_active' => 0
				];

				$carfinder = [
					'name' => __('Cars Finder'),
					'id' => 'services-carfinder',
					'url' => '/car-finder',
					'is_active' => 0
				];

				$advertise = [
					'name' => __('Advertise With Us'),
					'id' => 'services-advertise',
					'url' => '/inquiry/index/advertise?success=',
					'is_active' => 0
				];

				$buysellyourcar = [
					'name' => __('Buy/Sell your Car'),
					'id' => 'services-buysellyourcar',
					'url' => '/buy-sell-your-car',
					'is_active' => 0
				];

			/*----------------------------------------------------*/
		
		$newspromos = [
			'name' => __('NEWS & PROMOS'),
			'id' => 'menu-newspromos',
			'url' => '/news/category/news',
			'is_active' => 0
		];
		
		$support = [
			'name' => __('SUPPORT'),
			'id' => 'menu-support',
			'url' => '/inquiry/index/support?success=',
			'is_active' => 0
		];
		
		$data9 = [
			'name' => __('test'),
			'id' => 'menu-test',
			'url' => '/test',
			'is_active' => 0
		];
		

		$homenode 		= new Node($home, 'id', $tree, $menu);
		$aboutusnode 	= new Node($aboutus, 'id', $tree, $menu);
		
			/* About us child */
			$whowearenode 		= new Node($whoweare, 'id', $tree, $menu);
			$whatweoffernode 	= new Node($whatweoffer, 'id', $tree, $menu);
			$missionnode 		= new Node($mission, 'id', $tree, $menu);
			$careersnode 		= new Node($careers, 'id', $tree, $menu);
			$contactusnode 		= new Node($contactus, 'id', $tree, $menu);
			/*------*/
		
		$partsnode 		= new Node($parts, 'id', $tree, $menu);

			/* Shop parts child */
			$bodypartsmirrors 			= new Node($bodypartsmirrors, 'id', $tree, $menu);
			$breakssuspensionsteering 	= new Node($breakssuspensionsteering, 'id', $tree, $menu);
			$enginedrivetrain 			= new Node($enginedrivetrain, 'id', $tree, $menu);
			$headlightslighting 		= new Node($headlightslighting, 'id', $tree, $menu);
			$interioraccessories 		= new Node($interioraccessories, 'id', $tree, $menu);
			$exterioraccessories 		= new Node($exterioraccessories, 'id', $tree, $menu);
			$wheelstires 				= new Node($wheelstires, 'id', $tree, $menu);
			$toolsgarage 				= new Node($toolsgarage, 'id', $tree, $menu);
			/*------*/

		$carsnode 		= new Node($cars, 'id', $tree, $menu);

			/* Cars child */
			$carss 			= new Node($carss, 'id', $tree, $menu);
			$suv 			= new Node($suv, 'id', $tree, $menu);
			$pickup 		= new Node($pickup, 'id', $tree, $menu);
			$vans 			= new Node($vans, 'id', $tree, $menu);
			/*------*/


		$merchandisenode = new Node($merchandise, 'id', $tree, $menu);

			/* Merchandise child */
			$apparel 				= new Node($apparel, 'id', $tree, $menu);
			$autobodytools 			= new Node($autobodytools, 'id', $tree, $menu);
			$carcare 				= new Node($carcare, 'id', $tree, $menu);
			$codereaders 			= new Node($codereaders, 'id', $tree, $menu);
			$garageaccessories 		= new Node($garageaccessories, 'id', $tree, $menu);
			$jacksliftsstands 		= new Node($jacksliftsstands, 'id', $tree, $menu);
			$mobileelectronics 		= new Node($mobileelectronics, 'id', $tree, $menu);
			$repairmanuals 			= new Node($repairmanuals, 'id', $tree, $menu);
			$tirewheelcare 			= new Node($tirewheelcare, 'id', $tree, $menu);
			$toolboxesaccessories 	= new Node($toolboxesaccessories, 'id', $tree, $menu);
			$tools 					= new Node($tools, 'id', $tree, $menu);
			/*------*/

		$servicesnode 	= new Node($services, 'id', $tree, $menu);

			/* Services child */
			$insurance 				= new Node($insurance, 'id', $tree, $menu);
			$carmaintenance 		= new Node($carmaintenance, 'id', $tree, $menu);
			$partsinstallation 		= new Node($partsinstallation, 'id', $tree, $menu);
			$rentalsandleasing 		= new Node($rentalsandleasing, 'id', $tree, $menu);
			$carcareanddetailing 	= new Node($carcareanddetailing, 'id', $tree, $menu);
			$partsfinder 			= new Node($partsfinder, 'id', $tree, $menu);
			$carfinder 				= new Node($carfinder, 'id', $tree, $menu);
			$advertise 				= new Node($advertise, 'id', $tree, $menu);
			$buysellyourcar 		= new Node($buysellyourcar, 'id', $tree, $menu);
			/*------*/

		$newspromosnode = new Node($newspromos, 'id', $tree, $menu);
		$supportnode 	= new Node($support, 'id', $tree, $menu);
		

		$menu->addChild($homenode);
		$menu->addChild($aboutusnode);
		
			/* About us child */
			$aboutusnode->addChild($whowearenode);
			$aboutusnode->addChild($whatweoffernode);
			$aboutusnode->addChild($missionnode);
			$aboutusnode->addChild($careersnode);
			$aboutusnode->addChild($contactusnode);
			/*------*/
			
		$menu->addChild($partsnode);

			/* Shop parts child */
			$partsnode->addChild($bodypartsmirrors);
			$partsnode->addChild($breakssuspensionsteering);
			$partsnode->addChild($enginedrivetrain);
			$partsnode->addChild($headlightslighting);
			$partsnode->addChild($interioraccessories);
			$partsnode->addChild($exterioraccessories);
			$partsnode->addChild($wheelstires);
			$partsnode->addChild($toolsgarage);
			/*------*/

		$menu->addChild($carsnode);

			/* Cars child */
			$carsnode->addChild($carss);
			$carsnode->addChild($suv);
			$carsnode->addChild($pickup);
			$carsnode->addChild($vans);
			/*------*/

		$menu->addChild($merchandisenode);

			/* Merchandise child */
			$merchandisenode->addChild($apparel);
			$merchandisenode->addChild($autobodytools);
			$merchandisenode->addChild($carcare);
			$merchandisenode->addChild($codereaders);
			$merchandisenode->addChild($garageaccessories);
			$merchandisenode->addChild($jacksliftsstands);
			$merchandisenode->addChild($mobileelectronics);
			$merchandisenode->addChild($repairmanuals);
			$merchandisenode->addChild($tirewheelcare);
			$merchandisenode->addChild($toolboxesaccessories);
			$merchandisenode->addChild($tools);
			/*------*/

		$menu->addChild($servicesnode);

			/* Services child */
			$servicesnode->addChild($insurance);
			$servicesnode->addChild($carmaintenance);
			$servicesnode->addChild($carcare);
			$servicesnode->addChild($partsinstallation);
			$servicesnode->addChild($rentalsandleasing);
			$servicesnode->addChild($carcareanddetailing);
			$servicesnode->addChild($partsfinder);
			$servicesnode->addChild($carfinder);
			$servicesnode->addChild($advertise);
			$servicesnode->addChild($buysellyourcar);
			/*------*/

		$menu->addChild($newspromosnode);
		$menu->addChild($supportnode);
		
		return $this;
	}
}