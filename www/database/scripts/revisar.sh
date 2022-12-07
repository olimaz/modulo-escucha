for file1 in *.wav; do
    file2="${file1%.wav}_64k.mp3"
    if [[ -e "$file2" ]]; then
        printf '%s\t%s\n' "$file1" "$file2"
    else
        printf '%s\t%s\n' "$file1 no tiene su $file2"

    fi
done
