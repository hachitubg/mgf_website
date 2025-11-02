#!/bin/bash

# Script để đổi tên tất cả file index.html thành index.php trong toàn bộ dự án

# Tìm tất cả file index.html và đổi tên
find . -name "index.html" -type f -exec bash -c 'mv "$1" "${1%.html}.php"' _ {} \;

echo "Đã đổi tên tất cả file index.html thành index.php."