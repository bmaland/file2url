(defun file2url ()
  "Uploads the file in the current buffer via file2url.sh, displays the resulting url."
  (interactive)
  (message "%s"
           (shell-command-to-string
            (concatenate 'string "file2url.sh " buffer-file-name))))
