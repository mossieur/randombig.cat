<?php
set_time_limit( 128 );

error_reporting( 0 );
ini_set( 'display_errors', 0 );

header( 'Access-Control-Allow-Origin: *' );
header( 'Access-Control-Allow-Methods: GET,POST,OPTIONS,DELETE,PUT' );

$gif = glob( __DIR__ . '/*.gif' );
$jfif = glob( __DIR__ . '/*.jfif' );
$jpeg = glob( __DIR__ . '/*.jpeg' );
$jpg = glob( __DIR__ . '/*.jpg' );
$mp4 = glob( __DIR__ . '/*.mp4' );
$png = glob( __DIR__ . '/*.png' );
$webm = glob( __DIR__ . '/*.webm' );

$files = array_merge( $gif, $jfif, $jpeg, $jpg, $mp4, $png, $webm );
$files = array_diff( $files, array( __DIR__ . '/lion-metro-left.png' ) );
$file = $files[ rand( 0, count( $files ) -1 ) ];
$path = pathinfo( $file );
$parts = parse_url( basename( $_SERVER['REQUEST_URI'] ) );
	
if(isset($parts['query']) && !empty($parts['query']))
{
	parse_str( $parts['query'], $query );
	
	if( isset( $query['filter'] ) && !empty( $query['filter'] ) )
	{
		foreach( $files as $a => $b )
		{
			if( preg_match( '/gif/', $query['filter'] ) && preg_match( '/.gif$/', $b ) )
			{
				unset( $files[$a] );
			}
			
			if( preg_match( '/jfif/', $query['filter'] ) && preg_match( '/.jfif$/', $b ) )
			{
				unset( $files[$a] );
			}
			
			if( preg_match( '/jpeg/', $query['filter'] ) && preg_match( '/.jpeg$/', $b ) )
			{
				unset( $files[$a] );
			}
			
			if( preg_match( '/jpg/', $query['filter'] ) && preg_match( '/.jpg$/', $b ) )
			{
				unset( $files[$a] );
			}
			
			if( preg_match( '/mp4/', $query['filter'] ) && preg_match( '/.mp4$/', $b ) )
			{
				unset( $files[$a] );
			}
			
			if( preg_match( '/png/', $query['filter'] ) && preg_match( '/.png$/', $b ) )
			{
				unset( $files[$a] );
			}
			
			if( preg_match( '/webm/', $query['filter'] ) && preg_match( '/.webm$/', $b ) )
			{
				unset( $files[$a] );
			}
		}
		
		$file = $files[ rand( 0, count( $files ) -1 ) ];
		$path = pathinfo( $file );
	}
	elseif( isset( $query['include'] ) && !empty( $query['include'] ) )
	{
		$include = array( );
		
		foreach( $files as $a => $b )
		{			
			if( preg_match( '/gif/', $query['include'] ) && preg_match( '/.gif$/', $b ) )
			{
				$include[] = $files[$a];
			}
			
			if( preg_match( '/jfif/', $query['include'] ) && preg_match( '/.jfif$/', $b ) )
			{
				$include[] = $files[$a];
			}
			
			if( preg_match( '/jpeg/', $query['include'] ) && preg_match( '/.jpeg$/', $b ) )
			{
				$include[] = $files[$a];
			}
			
			if( preg_match( '/jpg/', $query['include'] ) && preg_match( '/.jpg$/', $b ) )
			{
				$include[] = $files[$a];
			}
			
			if( preg_match( '/mp4/', $query['include'] ) && preg_match( '/.mp4$/', $b ) )
			{
				$include[] = $files[$a];
			}
			
			if( preg_match( '/png/', $query['include'] ) && preg_match( '/.png$/', $b ) )
			{
				$include[] = $files[$a];
			}
			
			if( preg_match( '/webm/', $query['include'] ) && preg_match( '/.webm$/', $b ) )
			{
				$include[] = $files[$a];
			}
		}
		
		$files = $include;
		$file = $files[ rand( 0, count( $files ) -1 ) ];
		$path = pathinfo( $file );
	}
}

if( isset( $_GET['url'] ) )
{
	header( 'Content-Type: text/plain' );
	echo basename( $file );
}
elseif( isset( $_GET['json'] ) )
{
	$json = array( 'url' => ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? "https" : "http" ) . '://' . $_SERVER[HTTP_HOST] . '/' . rawurlencode( basename( $file ) ) );
	header( 'Content-Type: application/json' );
	echo json_encode( $json, JSON_PRETTY_PRINT );
}
elseif( isset( $_GET['files'] ) )
{
	natsort( $files );
	$files = array_values( $files );
	header( 'Content-Type: application/json' );
	echo str_replace( __DIR__ . '/', '', json_encode( $files, JSON_UNESCAPED_SLASHES ) );
}
elseif( isset( $_GET['robot'] ) )
{
	header('Location: https://discord.com/oauth2/authorize?client_id=1082270646131765258&permissions=537159744&scope=applications.commands%20bot');
	exit;
}
else
{
?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="theme-color" content="#FFFFFF">

		<title>randombig.cat</title>
		
		<meta name="description" content="Hello World, This Is Big Cat">
		<meta name="twitter:title" content="randombig.cat – ROAR!">
		<meta name="twitter:description" content="Hello World, This Is Big Cat">
<?php
if( $path['extension'] !== 'mp4' && $path['extension'] !== 'webm')
{
	echo '		<meta name="twitter:image" content="' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/" . basename( $file ) . '">
		<meta name="twitter:card" content="summary">
';
}
?>
		<meta property="og:site_name" content="randombig.cat">
		<meta property="og:type" content="website">
		<meta property="og:title" content="randombig.cat – ROAR!">
		<meta property="og:description" content="Hello World, This Is Big Cat">
		<meta property="og:url" content="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
<?php
if( $path['extension'] !== 'mp4' && $path['extension'] !== 'webm')
{
	echo '		<meta property="og:image" content="' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/" . basename( $file ) . '">
';
}
?>
		
		<link rel="author" type="text/plain" href="https://randombig.cat/humans.txt" />
		<link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%20100%20100'%3E%3Cdefs%3E%3CclipPath%20id='a'%3E%3Cpath%20d='M0%201080h1920V0H0z'/%3E%3C/clipPath%3E%3C/defs%3E%3Cg%20clip-path='url(%23a)'%20transform='matrix(.2096%200%200%20-.226%20-151.27%20172.014)'%3E%3Cpath%20d='M1196.6%20409.66c-.045.041-2.975%202.721-7.174%206.457%206.884%205.948%209.394%2010.946%207.659%2015.25-4.167%2010.338-32.231%209.315-38.33%208.966l-18.112%2016.873.024.037c.429.674%209.783%2015.473%2011.902%2024.967%203.754-2.392%208.867-2.783%2014.237-3.187%201.512-.113%203.074-.23%204.632-.393l3.482-.365-1.455%203.185c-3.032%206.638-4.538%2021.221-3.355%2032.51%201.304%2012.469-2.554%2015.539-9.252%2018.144%201.893%205.798%202.482%2011.665%202.988%2016.769.069.704.139%201.387.209%202.06%203.185-.321%206.539-.712%2010.072-1.195l.541%203.963c-2.713.37-5.317.688-7.825.964%204.244%204.65%206.159%209.895%206.699%2015.084%201.785.158%203.603.311%205.496.453l-.299%203.989c-1.728-.13-3.4-.268-5.04-.411-.161%207.074-2.491%2013.706-4.512%2018.169l18.337%206.258-1.291%203.785-17.49-5.969c.17%205.96-2.377%2011.547-7.598%2016.649%204.255%209.929%207.075%2023.269-2.039%2032.721l-1.831.573-6.094-1.218a17.72%2017.72%200%200%201%203.293%206.299c1.896%206.636-.082%2014.325-5.877%2022.855-3.612%205.316-7.346%209.195-11.099%2011.957l14.388%2040.854-.805.884c-.356.392-6.477%206.666-32.044%208.711-.463%202.474-1.85%205.909-4.725%208.186%201.597.089%203.095.381%204.359.944%202.331%201.039%203.75%202.904%203.996%205.249.287%202.737-1.008%205.3-3.648%207.216-4.584%203.327-12.565%204.305-17.433%202.135-2.611-1.164-4.193-3.178-4.455-5.671-.161-1.542.293-3.85%203.377-6.088.918-.667%202.036-1.266%203.256-1.794-4.374-1.206-6.695-5.018-8.754-9.616-8.356-.188-17.909-.732-28.831-1.757l-2.135-.2.348-2.115c4.016-24.428%205.943-35.776%206.862-41.033-4.407%201.028-9.134%201.049-13.812-.844l-.331-.16c-5.666-2.888-8.773-4.858-10.709-13.407-2.051.115-4.53-.734-7.416-2.574-15.142-9.655-41.155-46.365-39.731-85.536-.084-.029-.165-.06-.25-.088l-34.965%2032.573c2.672%201.888%204.417%204.286%204.564%206.761.051.871-.057%201.933-.368%203.046l.014.051c.033.155-.075.407-.258.706-.542%201.497-1.471%203.031-2.944%204.287-1.345%201.147-3.441%202.307-6.543%202.591l-1.377%205.73-.84.292a34.737%2034.737%200%200%201-1.798%203.638c-.02.54-.293.888-.775%201.259-1.011%201.509-2.142%202.734-3.377%203.375-4.569%202.371-13.29%202.679-22.523%203.006l-1.199.043-13.551%2012.597%202.124-.222c2.521-.264%209.837-.281%2013.374%202.768%201.166%201.004%201.815%202.275%201.876%203.674.334%207.614-8.403%208.529-12.134%208.919l-23.103%202.419c-7.747%206.909-20.177%2017.992-20.393%2018.169-4.169%203.394-12.908%204.169-16.144%202.248l-.239-.166c-2.881-2.335-3.665-3.101-3.745-3.181l-1.613-1.608%2016.576-12.786-22.574%202.363-.209-1.989c-.534-5.109%201.39-15.079%2012.502-16.243l30.142-3.155%206.437-6.265c-7.342%201.663-18.701%202.229-25.076-.166-7.091-2.664-12.115-4.112-17.145-.146-4.787%203.773-8.566%207.711-12.22%2011.519-2.898%203.019-5.894%206.141-9.339%209.121-7.037%206.086-24.287%2013.656-38.366%2012.038-12.195-1.4-20.706-4.563-25.453-15.984l-.942-2.265%202.409-.466c.663-.129%201.417-.268%202.249-.422%2012.053-2.229%2043.321-8.011%2046.843-28.437-.459.075-.928.154-1.406.234-7.392%201.247-17.517%202.956-28.724-7.761l-17.787-17.012%207.152%201.687c5.837%201.377%2022.512%204.259%2029.483%201.094%201.976-.897%204.582-2.182%207.601-3.671%2011.189-5.518%2026.514-13.075%2035.921-14.06%209.09-.955%2018.547%203.304%2024.804%206.121%202.108.949%203.929%201.769%205.139%202.121%205.706%201.658%209.852.002%2019.284-7.704%203.807-3.111%208.43-4.259%2013.106-4.259%209.313%200%2018.832%204.559%2022.509%207.26%202.949%202.166%205.501%203.311%208.351%203.992l38.801-36.734c-7.88-13.856-10.56-17.59-45.977-16.003l-3.258.146%201.346-2.97c.299-.66%204.731-10.165%2014.798-18.44-67.341-2.19-101.17-6.783-170.96-38.84-10.406-3.843-19.909-.921-24.342%203.428-3.167%203.108-4.138%207.028-2.732%2011.038%201.849%205.274%2012.979%2023.002%2078.525%2029.682%2011.57.941%2024.269.223%2036.549-.471%2024.484-1.386%2047.611-2.694%2059.302%209.18%205.864%205.955%208.302%2014.558%207.458%2026.259-.014.274-.413%206.769-6.683%2011.858-6.817%205.533-17.62%207.178-32.029%204.906-5.4-.631-8.445.669-11.973%202.177-3.803%201.625-8.114%203.463-15.765%203.273-21.281-.544-30.817-6.77-34.066-9.59l-11.112%207.905-2.319-3.26%2012.448-8.855-.729.049c-8.31.557-25.949-11.755-27.931-13.159l-4.349-3.082%205.303-.539c2.366-.241%2058.053-5.889%2065.883-4.652%208.035%201.266%2027.067%207.882%2032.951%2011.08%202.003%201.089%207.856-.674%2010.755-4.733%202.276-3.187%201.659-6.428-1.834-9.634-8.7-7.984-27.394-6.534-43.885-5.255-3.625.282-7.049.548-10.324.714l-2.106.108c-20.636%201.066-83.434%204.314-111.32-6.551-28.648-11.163-22.887-42.58-22.354-45.183.135-1.637%201.537-14.092%2013.464-23.508%208.083-6.381%2018.953-9.814%2032.461-10.291-2.438-11.802-13.985-25.277-20.075-27.433-7.104-2.514-6.774-10.317-6.484-17.202.078-1.847.159-3.757.112-5.554-.191-7.337-.589-22.605-8.04-30.826-7.716-8.514-5.49-21.633-1.239-30.281%202.866-5.832%2025.121-35.612%2037.989-42.796%203.534-1.973%206.665-2.705%209.366-2.705%205.803%200%209.62%203.377%2011.18%205.087a31.234%2031.234%200%200%201%202.699-.125c6.358%200%209.736%202.204%2011.489%204.195.41.465.758.971%201.065%201.495a5.12%205.12%200%200%201%201.326-.769%205.228%205.228%200%200%201%201.891-.342c1.862%200%203.959.89%206.082%202.611%203.354%202.717%203.638%205.399%203.287%207.17-1.324%206.659-13.863%2011.057-19.192%2012.639-3.244.964-6.159%201.192-8.731%201.393-5.386.421-8.944.699-12.826%206.838-5.478%208.66-2.986%2011.367%206.283%2021.44l.778.846c8.543%209.296%2013.639%209.611%2025.952%2010.373%201.023.063%202.091.129%203.209.204%2015.719%201.045%2023.501%2010.375%2028.525%2018.387%204.359%206.952%206.922%2010.249%2011.365%2013.062%204.83-4.715%207.408-7.544%203.832-17.656-1.178-3.334-2.384-6.429-3.549-9.421-3.124-8.018-5.592-14.352-5.179-19.332.502-6.056.653-6.723.804-7.386.281-1.271%201.124-1.505%203.376-2.128%205.011-1.387%2018.323-5.074%2022.993-12.927%201.904-3.202%203.452-6.304%204.949-9.305%203.401-6.815%206.338-12.701%2011.681-15.703.244-.138%2021.652-11.983%2032.037-11.983%201.437%200%202.663.227%203.593.743%201.67.926%203.256%202.171%204.936%203.488%203.964%203.109%208.063%206.337%2014.108%206.227%208.793-.146%2015.687%201.887%2018.907%205.568%202.457%202.806%201.93%206.231-1.565%2010.18l-.407.47c-2.503%202.914-10.119%2011.78-18.456%207.578-5.963-3.006-12.563-6.102-15.403-4.866-3.51%201.536-17.44%2011.725-19.318%2016.905-.949%202.617-1.065%204.686-.344%206.151.636%201.293%202.032%202.289%204.149%202.963%201.344.428%202.793.798%204.194%201.155%204.718%201.204%209.174%202.342%2010.857%205.798.511%201.049%201.158%202.797%201.978%205.01%201.821%204.912%204.867%2013.133%207.327%2015.033%201.494%201.154%203.129%202.047%204.711%202.909%202.589%201.412%205.034%202.746%206.703%205.067%202.074%202.884%209.626%2020.124%2012.01%2026.061%2012.682-5.765%2028.407-12.687%2044.9-12.687%201.061%200%202.127.039%203.194.099-1.596-4.04-5.798-12.762-7.51-16.238l-1.337-2.713%203.02-.168c.366-.021%202.465-.128%205.784-.127%206.773%200%2018.626.451%2031.182%202.995l-1.321-22.929%202.765.871c2.227.703%2011.765%203.804%2022.021%208.541%205.513-14.796%206.681-16.864%2010.605-23.049%201.937-3.054%204.727-6.048%207.425-8.944%202.886-3.096%205.61-6.021%206.694-8.394.542-1.189%201.138-2.338%201.714-3.45%201.879-3.625%203.652-7.05%203.528-11.567-.11-4.009%202.207-8.335%205.904-11.02%201.827-1.329%205.098-3.05%209.773-3.05%202.24%200%204.804.395%207.684%201.419a29.873%2029.873%200%200%201%207.33%203.807l.541-.693c.256-.328%206.244-7.889%2013.696-7.888.137%200%20.275.002.413.008%203.515.133%206.665%201.908%209.388%205.285%201.562-2.692%205.228-4.253%208.997-3.807%204.799.57%208.53%204.147%209.981%209.57%201.15%204.293.343%208.302-2.271%2011.288-2.6%202.972-6.881%204.64-10.64%204.15-.378-.048-.785-.111-1.219-.177-3.585-.55-8.494-1.304-13.33%203.342-5.122%204.92-9.115%2017.48-9.905%2020.094.328%201.377%201.44%205.615%203.718%2010.484%202.541%205.432%204.262%2017.104%201.867%2023.906a78.373%2078.373%200%200%201%206.002-.236c7.935%200%2016.312%201.299%2020.473%205.425.403.401%201.035%201.07%201.706%201.918%202.209-2.932%206.875-7.828%2013.85-8.558a26.04%2026.04%200%200%201%202.717-.142c8.077%200%2013.548%203.756%2013.801%203.933l2.044%201.429z'%20fill='%23ef6950'/%3E%3Cpath%20d='m780.06%20630.2%209.852%209.46%207.187%206.623s7.521%202.387%209.976%202.515c2.455.127%2012.188.235%2012.729-.447.541-.683%207.547-3.351%207.547-3.351s3.503-3.509%203.795-3.736%205.971-5.423%206.812-5.797c.841-.375%209.296-6.143%209.714-5.746.418.396%209.326-.958%209.326-.958l8.771%202.424%205.98%203.031%206.51%203.358%206.598%201.207%204.623-.155s12.027-5.624%2012.733-6.401%204.951-4.403%204.951-4.403l7.98-.705%207.318.391%208.855%202.609%207.789%202.845%209.045%202.809%2011.364%202.591%206.169-3.144s2.915-2.895%202.761-3.634c-.152-.738-2.032-4.506-2.032-4.506l-2.071-4.12-4.981-2.002-9.177-.086-6.353-1.86-5.972-1.897-5.871-4.531-7.708-2.25-10.489-2.416-8.229%201.85-5.981%205.389-3.663%202.26-8.723%203.158-7.21-.515-7.092-2.416-8.362-2.408-9.498-3.172-9.202.945-6.498%202.802-8.248%204.114-5.168%202.29-5.876%202.739-6.026%202.503-4.036%202.3-4.907%202.388-13.311-1.147-10.228-1.582-4.274-2.584.307%202.985%202.503%201.125z'%20fill='%23e81123'/%3E%3Cpath%20d='m905.29%20645.23-7.946%203.269-11.268%202.214-5.854%201.135-20.543.669-6.778.033-11.451%202.936-10.146%209.466-5.008%204.472-7.833%209.647-4.797%204.97-6.91%204.368-5.903%204.298-7.068.952-4.796-.238-9.959-2.725s-3.917-2.718-3.959-3.426c-.043-.709-1.146-4.114-1.146-4.114l-.722-2.753s25.799-8.177%2025.98-8.258c.18-.082%208.17-3.085%208.761-3.462s7.34-5.927%207.34-5.927%202.522-3.034%203.043-3.879c.52-.845%201.741-4.839%201.797-4.905.056-.067%201.042-3.309%201.085-3.502s1.139-2.379%201.139-2.379l12.686-9.846s5.521-3.208%206.361-3.756c.839-.547%207.985-3.559%209.097-4.177s6.501-1.547%206.501-1.547%205.67%201.281%205.858%201.34c.187.06%2015.403%207.473%2015.403%207.473s6.103%201.258%206.598%201.208c.495-.051%202.928-.233%206.35-1.155s8.94-3.493%208.94-3.493l3.94-3.651%203.561-2.048s9.505-1.315%209.875-1.297%207.657.531%207.657.531l6.94%202.115%206.986%203.178%2014.444%204.486%204.12.998-1.596%203.739-1.631%203.967-9.226-2.006-19.018-1.651-10.718.243z'%20fill='%23ffb900'/%3E%3Cpath%20d='M797.52%20694.43c8.365.084%2010.481-.282%2017.583-2.538%207.102-2.255%2011.738-4.492%2013.858-6.04%202.121-1.548%203.719-1.871%206.84-5.839%203.121-3.969%208.505-9.285%2013.283-13.264%204.779-3.979%206.809-5.643%208.985-6.018s1.083-1.214%205.117.131c4.033%201.345%208.603%203.94%2017.76%203.628s7.613.238%2013.663-.948%206.347-.054%2010.3-2.627c3.954-2.572%204.278-3.015%2010.619-3.666%206.342-.651%2014.44-1.937%2022.713-2.747s11.065-.405%2013.128-2.407c2.064-2.003%203.476-2.06%203.327-3.516l-.249-2.424s-3.61.394-4.719-.332c-1.11-.727-5.366-1.378-6.832-1.929-1.465-.55-16.254-.793-22.516-.589-2.808.091-4.624.245-6.176.433-1.91.232-3.42.517-5.886.805-4.47.522-10.545%201.702-15.084%203.622s-5.068%202.657-10.957%202.822c-5.889.164-13.204%201.732-21.129%201.037-7.925-.694-10.916-.45-14.134.634-3.219%201.084-7.094%203.116-7.094%203.116s-9.219%206.286-10.896%209.537-3.715%206.036-4.855%207.786c-1.14%201.751-5.272%205.568-6.99%207.189-1.719%201.622-3.979%205.31-8.757%207.119-4.777%201.81-10.041%203.784-10.45%204.083s-2.557%201.757-2.557%201.757z'%20fill='%23107c10'/%3E%3Cpath%20d='M1084.9%20660.44s-4.587%2011.415-12.196%2011.959c-7.61.546-11.086-6.254-11.922-9.434s-1.546-19.57-8.416-31.168c9.954-4.562%2026.951-13.882%2031.37-7.684%204.42%206.199%203.727%2015.195-4.405%2026.352M1108.7%20652.04s8.972%208.864%2019.259%206.279c10.286-2.585%2015.12-14.039%2015.561-18.226.442-4.187-2.101-18.877-20.951-20.046-18.848-1.169-20.242%2017.942-3.913%2022.649M1141.4%20617.73c9.204-20.473.447-39.289-22.044-45.229M1143.4%20585.19l43.683%2014.908'%20fill='none'%20stroke='%23000'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M1137.7%20583.02s15.803-11.463%2017.219-27.95M1098.1%20638.32s-6.912%206.002%202.174%2020.761c9.086%2014.76-7.998%2018.433-7.998%2018.433'%20fill='none'%20stroke='%23000'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M1103.1%20669.22s18.403%209.389%2035.01-3.666'%20fill='none'%20stroke='%23000'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M1152.2%20600.36s20.666%2028.126%205.701%2043.644l-14.029-2.805s19.027%208.44%203.306%2031.578c-15.721%2023.137-33.221%2017.275-42.373%2012.228-27.781-15.189-25.276-14.069-25.276-14.069'%20fill='none'%20stroke='%23000'%20stroke-linecap='square'%20stroke-linejoin='bevel'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M1057.1%20615.71c3.978-.417%2033.319-5.876%2027.394-33.661-4.906-25.251%2019.898-22.736%2019.801-5.34-.101%2018.234.335%2032.014%2024.059%2032.923M1092.1%20561.66l-.872-8.33M1069.1%20571.82l-49.856%2024.252M1032.4%20664.49c6.811-14.978%207.697-24.199%207.768-41.053.07-16.933%204.713-32.333%204.713-32.333'%20fill='none'%20stroke='%23000'%20stroke-linecap='square'%20stroke-linejoin='round'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M1106.5%20551.47c9.034%206.26%2019.349%2016.743%2072.553%2020.725M1125.3%20553.46s17.862%202.55%2049.253-1.742'%20fill='none'%20stroke='%23000'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M1125.4%20568.1s6.489-52.461-37.593-47.343c-44.081%205.117-35.084%2051.265-34.3%2058.64'%20fill='none'%20stroke='%23000'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='m1011.6%20574.48%2023.041-2.412c13.634-1.427%2030.313-6.567%2030.894-13.038%203.626-25.391%2014.409-25.63%2019.629-26.103%203.573-.322-.654.07%202.827-.296%2014.089-1.474%2022.02.185%2024.65%2023.131'%20fill='none'%20stroke='%23000'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M1066.9%20551.59s20.77%201.98%2044.989-.682'%20fill='none'%20stroke='%23000'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M1159.9%20611.29c5.47-5.321%208.036-11.271%206.724-18.18%202.839-5.668%2012.318-26.672-4.132-39.997-1.057-8.736-1.146-20.792-8.538-30.575'%20fill='none'%20stroke='%23000'%20stroke-linecap='square'%20stroke-linejoin='bevel'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M1152.2%20485.19c4.094-4.116%2011.675-3.736%2019.631-4.569-3.136%206.864-4.776%2021.614-3.526%2033.549%201.249%2011.935-2.223%2013.974-9.271%2016.555'%20fill='none'%20stroke='%23000'%20stroke-linecap='square'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M1127.6%20466.94c3.647%206.028.52%207.361-2.225%2018.363-2.745%2011.003%204.476%2016.341%2012.373%2016.143s14.242-8.027%2013.359-16.858-11.967-26.271-11.967-26.271'%20fill='none'%20stroke='%23000'%20stroke-linecap='square'%20stroke-linejoin='round'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M1091.3%20677.62s-17.122%2017.838-32.914%2011.448c-6.684-3.406-9.5-4.703-11.244-21.362'%20fill='none'%20stroke='%23000'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M1001.5%20588.41c-2.247%2047.36%2037.063%2091.507%2046.436%2086.592'%20fill='none'%20stroke='%23000'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M1012.6%20635.42c9.147-8.582%2024.395-35.817-13.239-48.342M1158%20438.5%20961.02%20622.01M1133.1%20441.1%20945.12%20619.06M1053.9%20554.96l-26.063%204.742-13.167-6.506M1026.5%20592.5l9.161-34.219M1023.7%20613.18l16.568%205.681M1098.4%20510.68c1.737-2.611%202.022-8.997-2.492-14.354M1118.2%20532.15c3.688-8.932%204.856-34.378-12.644-44.769'%20fill='none'%20stroke='%23000'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M1119.7%20508.45c7.361-5.379%2017.883-16.124%2020.286%206.838%201.511%2014.423-6.714%2025.5-6.714%2025.5M985.84%20580.53c-8.815-15.5-10.802-20.067-48.581-18.375%200%200%2011.845-26.125%2042.055-29.288'%20fill='none'%20stroke='%23000'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M1065.6%20612.81c-.95-9.075-2.229-24.903%2017.165-16.125-1.607%206.007-8.277%2015.194-14.399%2015.835M1127.3%20608.75c-.812-7.75-1.116-26.674-20.067-10.267%202.706%205.298%2011.041%2010.583%2011.041%2010.583l5.972.003'/%3E%3Cpath%20d='M1009.8%20557.65c-3.854.403-25.363%201.442-25.367-14.202%200%200%201.048-24.807-12.39-39.111%200%200%2054.255%204.417%2037.13%2036.521M1064.1%20484.58l14.56-26.594c7.652%205.861%2010.714%2017.606%2011.371%2023.879'%20fill='none'%20stroke='%23000'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M1072.2%20498.81c-3.813-9.954-11.892-29.093-23.956%201.329'%20fill='none'%20stroke='%23000'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M1053%20515.93c-1.205-11.515-9.636-32.474-26.313-16.05M1034.5%20534.88c-1.679-16.038-2.779-42.11-15.635-30.49-12.854%2011.619-13.319%2012.029-13.319%2012.029M956.16%20541.07c-70.971-2.122-104.82-6.119-176.12-38.873-32.694-12.162-64.829%2036.235%2050.522%2047.99%2044.959%203.662%20105.1-17.361%20101.47%2032.873%200%200-1.041%2020.469-36.482%2014.88-11.876-1.394-13.52%205.804-27.919%205.436-26.38-.674-33.912-10.191-33.912-10.191l-12.477%208.875'%20fill='none'%20stroke='%23000'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M871.88%20586.26c-9.54.999-29.466%202.666-40.201%203.371-7.86.516-26.643-12.795-26.643-12.795s57.701-5.874%2065.369-4.665c7.667%201.208%2026.621%207.77%2032.307%2010.861%205.686%203.092%2022.537-7.219%2011.229-17.598-11.31-10.379-36.995-6.014-55.664-5.065s-84.126%204.786-112.6-6.31c-28.476-11.095-21.095-43.037-21.095-43.037s2.492-41.82%2069.248-30.04M890.05%20455.74c29.484-4.093%2052.374-8.751%2071.091-17.246s43.766-20.67%2068.356-9.419'%20fill='none'%20stroke='%23000'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M992.75%20447.5c29.359-14.888%2046.577-29.51%2090.869-27.108%2014.945.697%2037.06-10.667%2045.052-12.761s27.983-3.215%2034.434%203.181c4.778%204.737%2011.354%2016.408-19.299%2013.333'%20fill='none'%20stroke='%23000'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M1080.7%20459.81s37.606-17.914%2055.404-20.782c17.798-2.869%2018.4-1.927%2027.848-2.916s28.871-7.547%207.042-26.376'%20fill='none'%20stroke='%23000'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M1157.9%20438.26c12.179.977%2056.382.622%2029.164-21.665M1180.7%20421.29c7.924-6.862%2014.744-13.106%2014.744-13.106s-6.25-4.373-15.163-3.441c-8.912.934-13.783%209.738-13.783%209.738M1014%20423.61c-.994-3.496-8.177-18.077-8.177-18.077s42.14-2.341%2066.649%2014.606M1044.8%20407.62l-1.231-21.362s50.064%2015.776%2049.871%2033.252'%20fill='none'%20stroke='%23000'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='m1077.9%20401.46%203.826-14.808s31.097%2013.711%2036.666%2023.686M1067.2%20395.71c6.29-16.988%207.274-18.6%2011.203-24.792%203.928-6.193%2011.961-12.564%2014.25-17.58s5.602-9.384%205.422-15.9c-.179-6.517%207.578-15.374%2020.691-10.713%2013.113%204.66%2018.19%2016.818%205.648%2014.993-10.38-1.511-12.918-6.943-12.918-6.943'%20fill='none'%20stroke='%23000'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M1134.2%20406.6c4.643-3.811%203.029-19.227.114-25.457-2.914-6.23-3.972-11.398-3.972-11.398s4.42-15.545%2010.586-21.469c6.167-5.925%2012.57-4.176%2016.191-3.706%205.362.695%2013.119-3.986%2010.723-12.937-2.749-10.269-13.055-9.442-15.373-5.178-2.319%204.265-5.831%2013.933-12.453%2013.119-6.62-.816-11.142-10.397-11.142-10.397s11.969-15.33%2021.513-.996M957.39%20636.3s-3.403%2013.115-7.774%2015.383c-5.563%202.887-19.391%202.477-30.168%203.159-8.816.557-15.497%204.112-19.327%205.877-5.435%202.505-21.026%204.044-28.353%201.292-7.326-2.752-13.205-4.482-19.087.156-8.731%206.883-13.946%2014.051-21.629%2020.697-6.24%205.397-23.091%2013.143-36.829%2011.565-11.373-1.306-19.354-3.986-23.834-14.765%2011.333-2.193%2049.468-7.693%2050.991-33.157-7.956.833-18.55%205.294-31.026-6.639l-12.477-11.932s21.649%205.107%2030.768.968c9.119-4.138%2031.301-16.348%2042.904-17.562%2011.604-1.215%2024.055%206.684%2029.176%208.172%206.568%201.911%2011.228-.002%2021.108-8.074%209.88-8.073%2027.175-1.337%2033.166%203.063s10.57%204.926%2018.168%205.471%2013.423%204.963%2013.64%208.627c.215%203.664-2.92%2010.528-13.728%208.14-10.807-2.388-21.291-6.485-26.044-8.669-4.753-2.183-17.664-3.848-23.66%201.304-5.996%205.153-16.341%2011.179-24.308%207.908-9.24-3.795-17.537-12.241-29.84-8.104-12.302%204.137-19.624%2015.786-28.361%2017.214'%20fill='none'%20stroke='%23000'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M953.86%20645.92c-4.202-1.775-14.119-5.261-33.399-3.746-19.28%201.516-22.258%203.63-33.274%207.105-10.578%203.337-29.581%201.703-38.956%202.46-6.647.537-15.27%207.807-22.49%2017.277-7.219%209.47-19.281%2019.112-24.098%2021.124-4.817%202.013-11.887%203.424-11.887%203.424'%20fill='none'%20stroke='%23000'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='m925.99%20654.54-18.484%2017.182%208.081-.846c4.227-.443%2012.863.413%2013.044%204.541.181%204.129-2.885%206.061-10.344%206.842l-23.745%202.486s-20.588%2018.362-20.806%2018.54c-3.476%202.83-11.314%203.591-13.861%202.079-2.884-2.337-3.592-3.043-3.592-3.043l20.356-15.702-27.599%202.89s-1.338-12.783%2010.721-14.046l30.832-3.227%2013.913-13.541M904.09%20474.63l-14.043-18.89s-9.238-16.21-34.452-28.149c-6.218-3.371-9.104-6.923-14.132-14.943-5.03-8.02-12.283-16.478-26.965-17.455-14.681-.976-20.666-.517-30.5-11.217-9.835-10.701-13.749-14.481-7.279-24.71%206.47-10.23%2013.089-6.231%2022.678-9.077%209.589-2.848%2023.835-9.354%2015.214-16.34-3.41-2.765-7.788-3.961-8.891%203.109-.649%204.157-3.249%207.378-33.329%208.182'%20fill='none'%20stroke='%23000'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M778.62%20344.62c8.44-1.859%2016.878-6.094%2011.851-17.298%200%200-6.529-9.539-18.72-2.732-12.191%206.806-34.13%2035.748-37.169%2041.931-3.039%206.184-6.841%2019.485.927%2028.056s8.335%2023.594%208.557%2032.117c.222%208.524-2.27%2018.336%205.039%2020.922%207.309%202.587%2019.636%2017.887%2021.583%2030.083M805.73%20336.96c.91-4.117-1.966-10.854-14.336-9.727M854.82%20427.15c5.526-5.423%209.707-8.71%205.422-20.829-4.285-12.12-9.139-21.667-8.621-27.921.518-6.255.649-6.604.763-7.118.114-.515%2019.866-3.924%2026.136-14.467%206.269-10.544%208.927-20.374%2015.891-24.287%206.963-3.913%2028.342-14.194%2033.68-11.234%205.337%202.96%2010.576%2010.12%2020.045%209.966%209.47-.153%2015.087%202.276%2017.372%204.885%202.283%202.609.24%205.505-1.558%207.536-1.798%202.032-9.035%2011.336-16.466%207.589-7.431-3.746-13.579-6.454-17.104-4.912-3.526%201.542-18.187%2011.959-20.398%2018.056-2.21%206.096-.468%209.935%205.079%2011.701%205.548%201.765%2012.151%202.415%2013.859%205.923s5.87%2017.651%209.881%2020.75%208.66%204.289%2011.014%207.561c2.354%203.273%2012.115%2026.083%2012.409%2027.291'%20fill='none'%20stroke='%23000'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M953.88%20332.34c-1.8%205.216-7.896%2016.076-13.374%2015.645M932.78%20345.92l-3.813-8.294%2010.193-8.607M928.96%20337.63l-13.095%201.371M957.01%20637.63l-1.379%205.735-3.093%201.078-2.691-1.101-9.664-1.062-8.237-.457M1135.3%20685.07l14.501%2041.175s-12.326%2013.523-83.237%206.871c7.064-42.969%207.65-45.377%207.65-45.377M1073.6%20689.05l32.4-3.392'%20fill='none'%20stroke='%23000'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3Cpath%20d='M1068.9%20718.83s27.255%205.327%2076.796-2.876M1070.5%20709.02s32.443%205.538%2071.886-2.283M1072.1%20699.93s30.517%203.167%2067.798-1.854M1096.5%20734.9c2.943%206.834%205.515%2010.587%2011.979%209.91%207.957-.833%208.877-9.643%208.877-9.643M1099.3%20754.16c-.703-6.708%2020.673-11.716%2021.558-3.262.92%208.785-20.673%2011.716-21.558%203.262z'%20fill='none'%20stroke='%23000'%20stroke-miterlimit='10'%20stroke-width='4'/%3E%3C/g%3E%3C/svg%3E">
<?php
if( $path['extension'] !== 'mp4' && $path['extension'] !== 'webm')
{
	echo '		<link rel="image_src" href="' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/" . basename( $file ) . '">
';
}
?>
		<link rel="canonical" href="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
		<link rel='dns-prefetch' href="//randombig.cat">
		<link rel="sitemap" type="application/xml" href="https://randombig.cat/sitemap.xml">
		<link rel="stylesheet" href="/css/main.css?v=<?php echo filemtime(__DIR__ . '/css/main.css'); ?>">
		
		<script type="application/ld+json">{
			"@context" : "https://schema.org",
			"@type" : "WebSite", 
			"name" : "Random Big Cat",
			"url" : "https://randombig.cat",
			"description": "Hello World, This Is Big Cat"
		}</script>
	</head>
	<body>
		<div id="main-div">
			<header>
				<h1>Hello World, This Is Big Cat</h1>
			</header>
			<div id="img-div">
				<div>
					<a href="/">
						<?php
						if( $path['extension'] === 'mp4' )
						{
							echo '<video id="bigcat-img" autoplay loop muted><source src="/' . basename( $file ) . '" type="video/mp4"></video>';
						}
						elseif( $path['extension'] === 'webm' )
						{
							echo '<video id="bigcat-img" autoplay loop muted><source src="/' . basename( $file ) . '" type="video/webm"></video>';
						}
						else
						{
							echo '<img id="bigcat-img" alt="Random Big Cat Picture" src="/' . basename( $file ) . '">';
						}
						?>
						
					</a>
				</div>
			</div>
			<footer>
				<table>
					<tr>
						<td>
							~<?php echo round( count( $files ), -1 ); ?> això no és suficient
						</td>
						<td>
							<a href="/roar">/roar</a>
							<a href="/roar.json">/roar.json</a>
							<a href="/cattes">/cattes</a>
						</td>
						<td itemscope itemtype="http://schema.org/Organization">
							<a href="/" itemprop="url">@<span itemprop="name">randombigcat</span></a> |
							<a href="https://github.com/mossieur/randombig.cat">github</a>
						</td>
					</tr>
				</table>
			</footer>
		</div>
	</body>
</html><?php
}
