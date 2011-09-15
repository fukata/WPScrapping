<?php get_header(); ?>

		<script type="text/javascript" src="<?=plugins_url('scrapping')?>/js/three/Three.js"></script>

		<script type="text/javascript" src="<?=plugins_url('scrapping')?>/js/three/RequestAnimationFrame.js"></script>
		<script type="text/javascript" src="<?=plugins_url('scrapping')?>/js/three/Stats.js"></script>

		<script type="text/javascript">

			var container, stats;

			var camera, scene, renderer;

			var cube, plane;

			var targetRotation = 0;
			var targetRotationOnMouseDown = 0;
			var targetRotationY = 0;
			var targetRotationOnMouseDownY = 0;
			var is_up = true;

			var mouseX = 0;
			var mouseXOnMouseDown = 0;
			var mouseY = 0;
			var mouseYOnMouseDown = 0;

			var windowHalfX = window.innerWidth / 2;
			var windowHalfY = window.innerHeight / 2;

			init();
			animate();

			function init() {

				container = document.createElement( 'div' );
				document.body.appendChild( container );

				var info = document.createElement( 'div' );
				info.style.position = 'absolute';
				info.style.top = '10px';
				info.style.width = '100%';
				info.style.textAlign = 'center';
				info.innerHTML = 'Drag to spin the cube';
				container.appendChild( info );

				camera = new THREE.Camera( 70, window.innerWidth / window.innerHeight, 1, 1000 );
				camera.position.y = 150;
				camera.position.z = 500;
				camera.target.position.y = 150;

				scene = new THREE.Scene();

				// Cube

				var materials = [];

				<?php
					$latest_scraps = Scrap::random_scraps(6);
					$images = array();
					foreach ($latest_scraps as $scrap) {
						$images[] = Scrap::get_thumbnail_url($scrap->ID, 'large');
					}
				?>
				var texstures = <?=json_encode($images);?>;

				for ( var i = 0; i < 6; i ++ ) {
					materials.push( [ new THREE.MeshBasicMaterial( { map: THREE.ImageUtils.loadTexture( texstures[i] ) } ) ] );
				}

				cube = new THREE.Mesh( new THREE.CubeGeometry( 200, 200, 200, 1, 1, 1, materials ), new THREE.MeshFaceMaterial() );
				cube.position.y = 150;
				cube.overdraw = true;
				scene.addObject( cube );

				// Plane

				plane = new THREE.Mesh( new THREE.PlaneGeometry( 200, 200 ), new THREE.MeshBasicMaterial( { color: 0xe0e0e0 } ) );
				plane.rotation.x = - 90 * ( Math.PI / 180 );
				plane.overdraw = true;
				scene.addObject( plane );

				renderer = new THREE.CanvasRenderer();
				renderer.setSize( window.innerWidth, window.innerHeight );

				container.appendChild( renderer.domElement );

				stats = new Stats();
				stats.domElement.style.position = 'absolute';
				stats.domElement.style.top = '0px';
				container.appendChild( stats.domElement );

				document.addEventListener( 'mousedown', onDocumentMouseDown, false );
				document.addEventListener( 'touchstart', onDocumentTouchStart, false );
				document.addEventListener( 'touchmove', onDocumentTouchMove, false );
			}

			//

			function onDocumentMouseDown( event ) {

				event.preventDefault();

				document.addEventListener( 'mousemove', onDocumentMouseMove, false );
				document.addEventListener( 'mouseup', onDocumentMouseUp, false );
				document.addEventListener( 'mouseout', onDocumentMouseOut, false );

				mouseXOnMouseDown = event.clientX - windowHalfX;
				mouseYOnMouseDown = event.clientY - windowHalfY;
				targetRotationOnMouseDown = targetRotation;
				targetRotationOnMouseDownY = targetRotationY;
			}

			function onDocumentMouseMove( event ) {

				mouseX = event.clientX - windowHalfX;
				mouseY = event.clientY - windowHalfY;

				targetRotation = targetRotationOnMouseDown + ( mouseX - mouseXOnMouseDown ) * 0.02;
				targetRotationY = targetRotationOnMouseDownY + ( mouseY - mouseYOnMouseDown ) * 0.02;
			}

			function onDocumentMouseUp( event ) {

				document.removeEventListener( 'mousemove', onDocumentMouseMove, false );
				document.removeEventListener( 'mouseup', onDocumentMouseUp, false );
				document.removeEventListener( 'mouseout', onDocumentMouseOut, false );
			}

			function onDocumentMouseOut( event ) {

				document.removeEventListener( 'mousemove', onDocumentMouseMove, false );
				document.removeEventListener( 'mouseup', onDocumentMouseUp, false );
				document.removeEventListener( 'mouseout', onDocumentMouseOut, false );
			}

			function onDocumentTouchStart( event ) {

				if ( event.touches.length == 1 ) {

					event.preventDefault();

					mouseXOnMouseDown = event.touches[ 0 ].pageX - windowHalfX;
					mouseYOnMouseDown = event.touches[ 0 ].pageY - windowHalfY;
					targetRotationOnMouseDown = targetRotation;
					targetRotationOnMouseDownY = targetRotationY;

				}
			}

			function onDocumentTouchMove( event ) {

				if ( event.touches.length == 1 ) {

					event.preventDefault();

					mouseX = event.touches[ 0 ].pageX - windowHalfX;
					mouseY = event.touches[ 0 ].pageY - windowHalfY;
					targetRotation = targetRotationOnMouseDown + ( mouseX - mouseXOnMouseDown ) * 0.05;
					targetRotationY = targetRotationOnMouseDownY + ( mouseY - mouseXOnMouseDownY ) * 0.05;
				}
			}

			//

			function animate() {

				requestAnimationFrame( animate );

				render();
				stats.update();

			}

			function render() {
				plane.rotation.z = ( targetRotation - cube.rotation.y ) * 0.05;
				cube.rotation.x += ( targetRotationY - cube.rotation.x ) * 0.05;
				cube.rotation.y += ( targetRotation - cube.rotation.y ) * 0.05;
				renderer.render( scene, camera );
			}

		</script>



<?php get_footer(); ?>
