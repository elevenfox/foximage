
param ($path = $(throw "ComputerName parameter is required."))

write-host "Target parent folder is:  $path"
write-host ""

Push-Location "${path}"

Get-ChildItem -Recurse -Filter *.7z |
ForEach-Object {
  Write-Host "-------------------------------"
  Write-Host "---- Processing "  $_.Name 
  Write-Host "-------------------------------"
  7z.exe e -p"www.5280bt.net" $_.Name
  $zip = -join($_.BaseName, '.zip')
  Remove-Item $_.Name
  7z.exe x -p"www.5280bt.net" $zip
  Remove-Item $zip
  write-host ""
}

Pop-Location