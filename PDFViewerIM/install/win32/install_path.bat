reg Query "HKLM\SYSTEM\CurrentControlSet\Control\Session Manager\Environment" /v path | findstr /i /c:"C:\pdfviewerbin\gs8.71\bin" >nul
 if not %errorlevel%== 0 REG ADD "HKLM\SYSTEM\CurrentControlSet\Control\Session Manager\Environment" /v Path /d "%PATH%;C:\pdfviewerbin\gs8.71\bin" /f

reg Query "HKLM\SYSTEM\CurrentControlSet\Control\Session Manager\Environment" /v path | findstr /i /c:"C:\pdfviewerbin\imagemagick-6.6.3.1" >nul
 if not %errorlevel%== 0 REG ADD "HKLM\SYSTEM\CurrentControlSet\Control\Session Manager\Environment" /v Path /d "%PATH%;C:\pdfviewerbin\imagemagick-6.6.3.1" /f
 
 