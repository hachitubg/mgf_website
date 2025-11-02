#!/bin/bash

# Script để cập nhật tất cả đường dẫn .html thành .php trong các file index.php

# Tìm tất cả file index.php và thay thế .html thành .php
find . -name "index.php" -type f -exec sed -i 's/\.html/\.php/g' {} \;

echo "Đã cập nhật tất cả đường dẫn .html thành .php trong các file index.php."