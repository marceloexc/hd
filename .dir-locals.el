((nil . ((compile-command . "php -S localhost:9000 -t .")
         (eval . (add-hook 'after-save-hook
                           (lambda ()
                             (when (and (derived-mode-p 'org-mode)
                                        (eq major-mode 'org-mode))
                               (org-html-export-to-html)))
                           nil t)))))
