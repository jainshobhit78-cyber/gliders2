param(
    [Parameter(Mandatory = $true)]
    [string] $Source,

    [Parameter(Mandatory = $true)]
    [string] $Output,

    [Parameter(Mandatory = $true)]
    [string] $Ffmpeg,

    [ValidateSet('veryfast', 'faster', 'fast', 'medium', 'slow')]
    [string] $Preset = 'medium',

    [ValidateRange(14, 30)]
    [int] $Crf = 18
)

$ErrorActionPreference = 'Stop'
$culture = [Globalization.CultureInfo]::InvariantCulture

# The master contains several different caption layouts. Each shot therefore has
# its own clean cinematic extraction so the rendered video contains no titles or
# corner watermark. Speed is the output-duration multiplier: >1 is slow motion.
$clips = @(
    @{ Name = 'Overhead fighter pass';       Start = 120.0; Length = 2.7; Speed = 0.78; Crop = '1280:600:320:190'; Motion = 'bank'; Grade = 'cool' },
    @{ Name = 'Formation break';              Start = 123.0; Length = 3.8; Speed = 0.95; Crop = '1280:600:300:190'; Motion = 'bank'; Grade = 'cool' },
    @{ Name = 'BAE Hawk brake parachute';     Start = 84.7;  Length = 2.8; Speed = 1.25; Crop = '1280:580:280:330'; Motion = 'push'; Grade = 'action' },
    @{ Name = 'Red Hawk deployment';          Start = 87.9;  Length = 2.2; Speed = 1.45; Crop = '1280:640:300:180'; Motion = 'push'; Grade = 'action' },
    @{ Name = 'LCA brake parachute';          Start = 90.3;  Length = 3.3; Speed = 1.05; Crop = '1280:600:300:310'; Motion = 'push'; Grade = 'action' },
    @{ Name = 'MiG-29 brake parachute';       Start = 95.0;  Length = 3.1; Speed = 1.15; Crop = '1280:420:300:430'; Motion = 'push'; Grade = 'action' },
    @{ Name = 'Su-30 deployment';             Start = 98.6;  Length = 3.3; Speed = 1.35; Crop = '1280:420:300:430'; Motion = 'push'; Grade = 'action' },
    @{ Name = 'Su-30 twin parachutes';        Start = 101.4; Length = 3.1; Speed = 1.25; Crop = '1280:420:320:430'; Motion = 'push'; Grade = 'action' },
    @{ Name = 'Formation heavy drop';         Start = 115.5; Length = 4.8; Speed = 0.80; Crop = '1280:560:320:190'; Motion = 'bank'; Grade = 'cool' },
    @{ Name = 'Freefall extraction';          Start = 14.0;  Length = 3.5; Speed = 1.05; Crop = '1280:500:260:160'; Motion = 'push'; Grade = 'cool' },
    @{ Name = 'Canopy inflation';             Start = 20.0;  Length = 3.8; Speed = 1.20; Crop = '1280:580:300:180'; Motion = 'push'; Grade = 'cool' },
    @{ Name = 'Precision stitching';          Start = 264.8; Length = 2.4; Speed = 0.80; Crop = '1280:480:260:220'; Motion = 'push'; Grade = 'warm' },
    @{ Name = 'Rigging inspection';           Start = 247.3; Length = 2.4; Speed = 0.80; Crop = '1280:480:260:220'; Motion = 'push'; Grade = 'warm' },
    @{ Name = 'Canopy packing';               Start = 329.0; Length = 2.5; Speed = 0.85; Crop = '1280:620:260:180'; Motion = 'push'; Grade = 'warm' },
    @{ Name = 'Su-30 cinematic finale';       Start = 101.5; Length = 3.25; Speed = 1.15; Crop = '1280:420:320:430'; Motion = 'push'; Grade = 'action' }
)

$transitions = @(
    'hblur', 'smoothleft', 'radial', 'wipeleft', 'pixelize', 'circleopen',
    'dissolve', 'smoothup', 'fadefast', 'hblur', 'diagtl', 'smoothleft',
    'zoomin', 'fadeblack'
)

$transitionDuration = 0.35
$filters = New-Object System.Collections.Generic.List[string]
$arguments = New-Object System.Collections.Generic.List[string]
$durations = New-Object System.Collections.Generic.List[double]

$arguments.Add('-hide_banner')
$arguments.Add('-y')

foreach ($clip in $clips) {
    $arguments.Add('-ss')
    $arguments.Add($clip.Start.ToString($culture))
    $arguments.Add('-t')
    $arguments.Add($clip.Length.ToString($culture))
    $arguments.Add('-i')
    $arguments.Add($Source)
    $durations.Add([double] $clip.Length * [double] $clip.Speed)
}

for ($index = 0; $index -lt $clips.Count; $index++) {
    $clip = $clips[$index]
    $speed = ([double] $clip.Speed).ToString('0.###', $culture)
    $duration = $durations[$index]
    $durationText = $duration.ToString('0.###', $culture)

    $chain = "[$index`:v]setpts=PTS-STARTPTS"

    if ([double] $clip.Speed -gt 1.02) {
        $chain += ',minterpolate=fps=50:mi_mode=mci:mc_mode=aobmc:me_mode=bidir:vsbmc=1'
    }

    $chain += ",setpts=$speed*PTS"
    $chain += ",crop=$($clip.Crop)"
    $chain += ',scale=1920:1080:force_original_aspect_ratio=decrease:flags=lanczos'
    $chain += ',pad=1920:1080:(ow-iw)/2:(oh-ih)/2:black'

    switch ($clip.Grade) {
        'warm' {
            $chain += ',eq=contrast=1.12:brightness=-0.01:saturation=1.02:gamma=0.98'
            $chain += ',colorbalance=rs=0.035:gs=0.012:bs=-0.018'
        }
        'cool' {
            $chain += ',eq=contrast=1.18:brightness=-0.022:saturation=1.04:gamma=0.96'
            $chain += ',colorbalance=rs=0.008:bs=0.038:gm=0.008'
        }
        default {
            $chain += ',eq=contrast=1.20:brightness=-0.018:saturation=1.08:gamma=0.97'
            $chain += ',colorbalance=rs=0.022:bs=0.025:gm=0.006'
        }
    }

    if ($clip.Motion -eq 'bank') {
        $chain += ",scale=2074:1166:flags=lanczos,rotate='0.055*sin(PI*t/$durationText)':ow=iw:oh=ih:fillcolor=black,crop=1920:1080"
    } else {
        $chain += ",scale=2048:1152:flags=lanczos,crop=1920:1080:x='64+18*t/$durationText':y='36+5*sin(t)'"
    }

    $chain += ',vignette=PI/5.5,unsharp=5:5:0.34:5:5:0,noise=alls=1.2:allf=t+u'
    $chain += ",fps=25,trim=duration=$durationText,setpts=PTS-STARTPTS,format=yuv420p[v$index]"
    $filters.Add($chain)
}

$accumulatedDuration = $durations[0]
$previousLabel = 'v0'

for ($index = 1; $index -lt $clips.Count; $index++) {
    $offset = $accumulatedDuration - $transitionDuration
    $offsetText = $offset.ToString('0.###', $culture)
    $outputLabel = if ($index -eq $clips.Count - 1) { 'final' } else { "x$index" }
    $transition = $transitions[$index - 1]

    $filters.Add("[$previousLabel][v$index]xfade=transition=$transition`:duration=$transitionDuration`:offset=$offsetText[$outputLabel]")
    $previousLabel = $outputLabel
    $accumulatedDuration += $durations[$index] - $transitionDuration
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
$arguments.Add($Preset)
$arguments.Add('-crf')
$arguments.Add($Crf.ToString($culture))
$arguments.Add('-profile:v')
$arguments.Add('high')
$arguments.Add('-level')
$arguments.Add('4.1')
$arguments.Add('-pix_fmt')
$arguments.Add('yuv420p')
$arguments.Add('-movflags')
$arguments.Add('+faststart')
$arguments.Add('-metadata')
$arguments.Add('title=Gliders India Aviation-First Cinematic Hero')
$arguments.Add($Output)

& $Ffmpeg @arguments

if ($LASTEXITCODE -ne 0) {
    throw "FFmpeg failed with exit code $LASTEXITCODE"
}

Write-Host ('Rendered {0} seconds across {1} aviation-led shots.' -f $accumulatedDuration.ToString('0.00', $culture), $clips.Count)
