<?php
/*

The Pie chart generator by Ashish Kasturia (http://www.123ashish.com)
Copyright (C) 2003 Ashish Kasturia (ashish at 123ashish.com)


The Pie chart generator is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, 
USA.



		$colarray[0,0] = 255;
		$colarray[0,1] = 0;
		$colarray[0,2] = 0;
		$colarray[1,0] = 255;
		$colarray[1,1] = 255;
		$colarray[1,2] = 0;
		$colarray[2,0] = 0;
		$colarray[2,1] = 255;
		$colarray[2,2] = 0;
		$colarray[3,0] = 0;
		$colarray[3,1] = 255;
		$colarray[3,2] = 255;
		$colarray[4,0] = 0;
		$colarray[4,1] = 0;
		$colarray[4,2] = 255;
		$colarray[5,0] = 255;
		$colarray[5,1] = 0;
		$colarray[5,2] = 255;


*/

class Pie
{
	var $imageWidth = 400;
	var $imageHeight = 300;
	var $bgR = 255;
	var $bgG = 255;
	var $bgB = 255;
	var $title = "Pie Chart - 123ashish.com";


	function create($varDesc, $varValues)
	{
		Header("Content-type: image/png");
		$image = ImageCreate($this->imageWidth, $this->imageHeight);


		$bgcolor = ImageColorAllocate($image, 
			$this->bgR, $this->bgG, $this->bgB);

		$white = ImageColorAllocate($image, 255, 255, 255);
		$black = ImageColorAllocate($image, 0, 0, 0);
		ImageFill($image, 0, 0, $bgcolor);
		$colarray[0][0] = 255;

		$colarray[0][1] = 0;
		$colarray[0][2] = 0;
		$colarray[1][0] = 255;
		$colarray[1][1] = 255;
		$colarray[1][2] = 0;
		$colarray[2][0] = 0;
		$colarray[2][1] = 255;
		$colarray[2][2] = 0;
		$colarray[3][0] = 0;
		$colarray[3][1] = 255;
		$colarray[3][2] = 255;
		$colarray[4][0] = 0;
		$colarray[4][1] = 0;
		$colarray[4][2] = 255;
		$colarray[5][0] = 255;
		$colarray[5][1] = 0;
		$colarray[5][2] = 255;
	

		$num = 0;
		foreach($varDesc as $v)
		{
/*	
	
			$r = rand (0, 255);
			$g = rand (0, 255);
			$b = rand (0, 255);
	
			$r = (rand (0, 1)) * 255;
			$g = (rand (0, 1)) * 255;
			$b = (rand (0, 1)) * 255;
		
*/		
	
			$r = $colarray[$num][0];
			$g = $colarray[$num][1];
			$b = $colarray[$num][2];
		
		
			$sliceColors[$num] = ImageColorAllocate($image, $r, $g, $b); 
			$num++;
		}

		// now $num has the number of elements

		// draw the box
		ImageLine($image, 0, 0, $this->imageWidth - 1, 0, $black);
		ImageLine($image, $this->imageWidth - 1, 0, $this->imageWidth - 1, $this->imageHeight - 1, $black);
		ImageLine($image, $this->imageWidth - 1, $this->imageHeight - 1, 0, $this->imageHeight - 1, $black);
		ImageLine($image, 0, $this->imageHeight - 1, 0, 0, $black);


		$total = 0;
		for ($x = 0; $x < $num; $x++)
		{
			$total += $varValues[$x];
		}

		// convert each slice into corresponding percentage of 360-degree circle
		for ($x = 0; $x < $num; $x++)
		{
			$angles[$x] = ($varValues[$x] / $total) * 360;
		}


		for($x = 0; $x < $num; $x++)
		{
			// calculate and draw arc corresponding to each slice
			ImageArc($image, 
				$this->imageWidth/4, 
				$this->imageHeight/2, 
				$this->imageWidth/3, 
				$this->imageHeight/3, 
				$angle,
				($angle + $angles[$x]), $sliceColors[$x]);

			$angle = $angle + $angles[$x];

			$x1 = round($this->imageWidth/4 + ($this->imageWidth/3 * cos($angle*pi()/180)) / 2);
			$y1 = round($this->imageHeight/2 + ($this->imageHeight/3 * sin($angle*pi()/180)) / 2);

			// demarcate slice with another line
			ImageLine($image, 
				$this->imageWidth/4,
				$this->imageHeight/2, 
				$x1, $y1, $sliceColors[$x]);

			
		}

		// fill in the arcs
		$angle = 0;
		for($x = 0; $x < $num; $x++)
		{
			$x1 = round($this->imageWidth/4 + 
				($this->imageWidth/3 * cos(($angle + $angles[$x] / 2)*pi()/180)) / 4);
			$y1 = round($this->imageHeight/2 + 
				($this->imageHeight/3 * sin(($angle + $angles[$x] / 2)*pi()/180)) / 4);

			ImageFill($image, $x1, $y1, $sliceColors[$x]);

			$angle = $angle + $angles[$x];
		}


		// put the desc strings
		ImageString($image, 5, $this->imageWidth/2, 60, "Legend", $black);
		for($x = 0; $x < $num; $x++)
		{
			$fl = sprintf("%.2f", $varValues[$x] * 100 / $total);
			$str = $varDesc[$x]." - ".$varValues[$x]." (".$fl."%)";
			ImageString($image, 3	, $this->imageWidth/2, ($x + 5) * 20, $str, $sliceColors[$x]);
		}

		// put the title
		ImageString($image, 5, 20, 20, $this->title, $black);
		

		ImagePng($image);
		ImageDestroy($image);

	}
}

$pie = new Pie;

if(isset($width))
{
	$pie->imageWidth = $width;
}

if(isset($height))
{
	$pie->imageHeight = $height;
}

if(isset($title))
{
	$pie->title = $title;
}

$varDesc = explode(",", $desc);
$varValues = explode(",", $values);

$pie->create($varDesc, $varValues);



?>
