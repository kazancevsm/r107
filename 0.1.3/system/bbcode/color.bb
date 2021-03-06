$aColors = array(
"black" => "#000000",
"blue" => "#0000FF",
"brown" => "#A52A2A",
"cyan" => "#00FFFF",
"darkblue" => "#00008B",
"darkred" => "#8B0000",
"green" => "#008000",
"indigo" => "#4B0082",
"olive" => "#808000",
"orange" => "#FFA500",
"red" => "#FF0000",
"violet" => "#EE82EE",
"white" => "#FFFFFF",
"yellow" => "#FFFF00",
"aqua" => "#00FFFF",
"fuchsia" => "#FF00FF",
"gray" => "#808080",
"lime" => "#00FF00",
"maroon" => "#800000",
"navy" => "#000080",
"purple" => "#800080",
"silver" => "#C0C0C0",
"teal" => "#008080"
);

if(array_key_exists($parm, $aColors))
{
	return "<span style='color:{$aColors[$parm]}'>$code_text</span>";
}
else
{
	if(preg_match("/(#[a-fA-F0-9]{3,6})/", $parm, $matches))
	{
		return "<span style='color:{$matches[1]}'>$code_text</span>";

	}
}