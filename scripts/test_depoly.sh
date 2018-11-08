#/bin/bash

usage() {
	 echo "usage: $0 directory-to-create"
}

if [ $# -lt 1 ]; then
	 usage
	 exit 1
fi

loc_root="/var/www"
target_loc="${loc_root}/$1"

# stop here until tested ...
echo "in debug ... do not use yet!"
exit

if [[ -e $target_loc ]] && [[ -f $target_loc ]]; then
	 echo "$target_loc is a file, not a directory"
	 usage
	 exit 1
fi

if [[ -e $target_loc ]] && [[ -d $target_loc ]]; then
	 echo "$target_loc directory already exists, please move it aside (save or delete) before proceeding"
	 exit 2
fi

mkdir -p $target_loc
cp ../index.html $target_loc
for dir in $(css doc html js php); do
	 mkdir -p $target_loc/$dir
	 cp ../$dir/* $target_loc/$dir
done

