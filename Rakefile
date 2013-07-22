desc "Package the project for deploying to WordPress.org"
task :package do
  cmds = [
    'cp -R ./ ../the-city-plaza',
    'cd ../',
    'rm -rf ./the-city-plaza/.git',
    'rm -rf ./the-city-plaza/.gitmodules',
    'rm -f ./the-city-plaza/README.rdoc',
    'rm -f ./the-city-plaza/changelog',
    'rm -f ./the-city-plaza/Rakefile',
    'rm -f ./the-city-plaza/notes.txt',
  
    'rm -rf ./the-city-plaza/lib/plaza-php/.git',
    'rm -rf ./the-city-plaza/lib/plaza-php/test',
    'rm -rf ./the-city-plaza/lib/plaza-php/build_docs',
    'rm -rf ./the-city-plaza/lib/plaza-php/etc',
    'rm -rf ./the-city-plaza/lib/plaza-php/storage/*',
    'rm -rf ./the-city-plaza/lib/plaza-php/lib/tutorials',
    'rm -f ./the-city-plaza/lib/plaza-php/README.rdoc',

    'zip -r the-city-plaza.zip ./the-city-plaza',
    'rm -rf the-city-plaza'
  ]

  `#{cmds.join(' ; ')}`
end

desc "Copy files that would go in the package [for deploying to WordPress.org] to a path"
task :package_to_path, :path do |t, args|
  cmds = [
    'cp -R ./ ../the-city-plaza',
    'cd ../',
    'rm -rf ./the-city-plaza/.git',
    'rm -rf ./the-city-plaza/.gitmodules',
    'rm -f ./the-city-plaza/README.rdoc',
    'rm -f ./the-city-plaza/changelog',
    'rm -f ./the-city-plaza/Rakefile',
    'rm -f ./the-city-plaza/notes.txt',

    'rm -rf ./the-city-plaza/lib/plaza-php/.git',
    'rm -rf ./the-city-plaza/lib/plaza-php/test',
    'rm -rf ./the-city-plaza/lib/plaza-php/build_docs',
    'rm -rf ./the-city-plaza/lib/plaza-php/etc',
    'rm -rf ./the-city-plaza/lib/plaza-php/storage/*',
    'rm -rf ./the-city-plaza/lib/plaza-php/lib/tutorials',
    'rm -f ./the-city-plaza/lib/plaza-php/README.rdoc',

    "cp -R ./the-city-plaza/* #{args[:path]}",
    'rm -rf the-city-plaza'
  ]

  `#{cmds.join(' ; ')}`
end