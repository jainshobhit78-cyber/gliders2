param(
    [Parameter(Mandatory = $true)]
    [string] $Source,

    [Parameter(Mandatory = $true)]
    [string] $Output,

    [Parameter(Mandatory = $true)]
    [string] $Ffmpeg
)

$ErrorActionPreference = 'Stop'

$clips = @(
    @{ Start = 74.0;  Length = 4.2; Speed = 1.0; Bank = $false }, # Factory reveal
    @{ Start = 265.0; Length = 3.0; Speed = 1.4; Bank = $false }, # Needle and webbing slow motion
    @{ Start = 247.0; Length = 4.2; Speed = 1.0; Bank = $false }, # Rigging inspection
    @{ Start = 329.0; Length = 4.2; Speed = 1.0; Bank = $false }, # Canopy packing
    @{ Start = 14.5;  Length = 3.0; Speed = 1.4; Bank = $false }, # Freefall deployment
    @{ Start = 21.0;  Length = 3.5; Speed = 1.2; Bank = $false }, # Pilot chute extraction
    @{ Start = 26.0;  Length = 3.5; Speed = 1.2; Bank = $false }, # Canopy inflation
    @{ Start = 112.0; Length = 4.2; Speed = 1.0; Bank = $false }, # Heavy-drop canopy formation
    @{ Start = 121.5; Length = 2.8; Speed = 1.5; Bank = $true  }, # Su-30 airborne bank
    @{ Start = 87.0;  Length = 2.8; Speed = 1.5; Bank = $false }, # Runway arrival and first brake chute
    @{ Start = 99.0;  Length = 3.0; Speed = 1.4; Bank = $false }, # Su-30 brake deployment, slowed
    @{ Start = 100.8; Length = 4.2; Speed = 1.0; Bank = $false }  # Su-30 twin brake-parachute finale
)

$transitions = @(
    'fadeblack', 'smoothleft', 'circleopen', 'radial', 'smoothup',
    'dissolve', 'fadegrays', 'slideright', 'smoothdown', 'circleclose', 'fadeblack'
)

$filters = New-Object System.Collections.Generic.List[string]
$arguments = New-Object System.Collections.Generic.List[string]
$arguments.Add('-hide_banner')
$arguments.Add('-y')

foreach ($clip in $clips) {
    $arguments.Add('-ss')
    $arguments.Add($clip.Start.ToString([Globalization.CultureInfo]::InvariantCulture))
    $arguments.Add('-t')
    $arguments.Add($clip.Length.ToString([Globalization.CultureInfo]::InvariantCulture))
    $arguments.Add('-i')
    $arguments.Add($Source)
}

for ($index = 0; $index -lt $clips.Count; $index++) {
    $clip = $clips[$index]
    $speed = $clip.Speed.ToString([Globalization.CultureInfo]::InvariantCulture)

    $chain = "[$index`:v]setpts=PTS-STARTPTS"
    if ($clip.Speed -gt 1.0) {
        $chain += ",minterpolate=fps=50:mi_mode=mci:mc_mode=aobmc:me_mode=bidir:vsbmc=1,setpts=$speed*PTS"
    }

    # The master contains legacy top/bottom title straps and a corner watermark.
    # A focused 2:1 cinematic extraction removes them without blur or filling.
    $chain += ',crop=1280:650:160:80,scale=1920:975:flags=lanczos,pad=1920:1080:0:52:black'
    $chain += ',eq=contrast=1.10:brightness=-0.015:saturation=0.92:gamma=0.98'
    $chain += ',colorbalance=rs=0.018:bs=0.028:gm=0.008,vignette=PI/5'

    if ($clip.Bank) {
        $chain += ",scale=2048:1152:flags=lanczos,rotate='0.045*sin(2*PI*t/4.2)':ow=iw:oh=ih:fillcolor=black,crop=1920:1080"
    }

    $chain += ',unsharp=5:5:0.28:5:5:0,fps=25,trim=duration=4.2,setpts=PTS-STARTPTS,format=yuv420p'
    $chain += "[v$index]"
    $filters.Add($chain)
}

$transitionDuration = 0.45
$accumulatedDuration = 4.2
$previousLabel = 'v0'

for ($index = 1; $index -lt $clips.Count; $index++) {
    $offset = $accumulatedDuration - $transitionDuration
    $offsetText = $offset.ToString('0.00', [Globalization.CultureInfo]::InvariantCulture)
    $outputLabel = if ($index -eq $clips.Count - 1) { 'final' } else { "x$index" }
    $filters.Add("[$previousLabel][v$index]xfade=transition=$($transitions[$index - 1]):duration=$transitionDuration`:offset=$offsetText[$outputLabel]")
    $previousLabel = $outputLabel
    $accumulatedDuration += 4.2 - $transitionDuration
}

$filterGraph = $filters -join ';'
$outputDirectory = Split-Path -Parent $Output
if ($outputDirectory -and -not (Test-Path $outputDirectory)) {
    New-Item -ItemType Directory -Path $outputDirectory -Force | Out-Null
}

$arguments.Add('-filter_complex')
$arguments.Add($filterGraph)
$arguments.Add('-map')
$arguments.Add('[final]')
$arguments.Add('-an')
$arguments.Add('-c:v')
$arguments.Add('libx264')
$arguments.Add('-preset')
$arguments.Add('medium')
$arguments.Add('-crf')
$arguments.Add('18')
$arguments.Add('-profile:v')
$arguments.Add('high')
$arguments.Add('-level')
$arguments.Add('4.1')
$arguments.Add('-pix_fmt')
$arguments.Add('yuv420p')
$arguments.Add('-movflags')
$arguments.Add('+faststart')
$arguments.Add('-metadata')
$arguments.Add('title=Gliders India Cinematic Hero')
$arguments.Add($Output)

& $Ffmpeg @arguments

if ($LASTEXITCODE -ne 0) {
    throw "FFmpeg failed with exit code $LASTEXITCODE"
}
