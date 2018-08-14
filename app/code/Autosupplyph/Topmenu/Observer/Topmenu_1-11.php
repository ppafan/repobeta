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
		
		$parts = [
			'name' => __('SHOP PARTS'),
			'id' => 'menu-shopparts',
			'url' => '/parts.html',
			'is_active' => 0
		];
		
			/*------------------ About us child ------------------*/
				$whoweare = [
					'name' => __('Who We Are'),
					'id' => 'aboutus-whoweare',
					'url' => '/who-we-are',
					'is_active' => 0
				];
				
				$whatweoffer = [
					'name' => __('What We Offer'),
					'id' => 'aboutus-whatweoffer',
					'url' => '/what-we-offer',
					'is_active' => 0
				];
				
				$mission = [
					'name' => __('Mission & Vision'),
					'id' => 'aboutus-mission',
					'url' => '/mission-vision',
					'is_active' => 0
				];
				
				$careers = [
					'name' => __('Careers'),
					'id' => 'aboutus-careers',
					'url' => '/careers',
					'is_active' => 0
				];
				
				$contactus = [
					'name' => __('Contact Us'),
					'id' => 'aboutus-contactus',
					'url' => '/contact-us',
					'is_active' => 0
				];
			/*----------------------------------------------------*/
		
		$cars = [
			'name' => __('SHOP CARS'),
			'id' => 'menu-shopcars',
			'url' => '/cars.html',
			'is_active' => 0
		];
		
		$merchandise = [
			'name' => __('SHOP MERCHANDISE'),
			'id' => 'menu-shopmerchandise',
			'url' => '/general-merchandise.html',
			'is_active' => 0
		];
		
		$services = [
			'name' => __('SERVICES'),
			'id' => 'menu-services',
			'url' => '/services',
			'is_active' => 0
		];
		
		$newspromos = [
			'name' => __('NEWS & PROMOS'),
			'id' => 'menu-newspromos',
			'url' => '/news-promos',
			'is_active' => 0
		];
		
		$support = [
			'name' => __('SUPPORT'),
			'id' => 'menu-support',
			'url' => '/support',
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
		$carsnode 		= new Node($cars, 'id', $tree, $menu);
		$merchandisenode = new Node($merchandise, 'id', $tree, $menu);
		$servicesnode 	= new Node($services, 'id', $tree, $menu);
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
		$menu->addChild($carsnode);
		$menu->addChild($merchandisenode);
		$menu->addChild($servicesnode);
		$menu->addChild($newspromosnode);
		$menu->addChild($supportnode);
		
		return $this;
	}
}