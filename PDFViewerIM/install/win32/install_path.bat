reg Query "HKLM\SYSTEM\CurrentControlSet\Control\Session Manager\Environment" /v path | findstr /i /c:"c:\pdfviewerbin\gs8.71\bin" >nul
 if not %errorlevel%== 0 REG ADD "HKLM\SYSTEM\CurrentControlSet\Control\Session Manager\Environment" /v Path /d "%PATH%;c:\pdfviewerbin\gs8.71\bin" /f
