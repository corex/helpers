# Changelog

## 4.2.0

### Added
- Added option to ignore methods when getting methods not in interface.

## 4.1.0

### Added
- Added Obj::getMethods().
- Added Obj::getPublicMethods().
- Added Obj::getPrivateMethods().
- Added Obj::getProtectedMethods().
- Added Obj::getMethodsNotInInterface().

## 4.0.0

### Changed
- Set php requirement to 7.4 || 8.0
- Made code more strict.

## 3.0.1

### Changed
- Lowered php requirement to 7.2

## 3.0.0

### Fixed
- Fixed missing exception on setProperty() on missing property.
- Fixed missing exception on setProperties() on missing property.
- Fixed missing exception on setProperty() on missing property.
- Fixed missing exception on hasMethod() on method not found.

### Changed
- Set php requirement to 7.4
- Renamed DataTrait::class to DataPublicTrait::class.

### Removed
- Removed old Bag::class in favor of DataPublicTrait::class.

## 2.4.2

### Fixed
- Fixed snakeCase().

### Added
- Added git attributes.

### Changed
- Refactored Obj::class.
- Refactored tests.

## 2.4.1

### Fixed
- Changed public methods in DataPrivateTrait to private methods.

## 2.4.0

### Added
- Added Traits/DataPrivateTrait for generic private data handling in class.

## 2.3.0

### Added
- Added Obj::getTraits().
- Added Obj::hasTrait().

### Changed
- Freshened up coding guidelines.

## 2.2.0

### Added
- Added trait ConstantsStaticTrait to get and check for all public and private constants on static class.

## 2.1.0

### Added
- Added Obj::getPublicConstants().
- Added Obj::getPrivateConstants().
- Added trait ConstantsTrait to get and check for all, public and private constants.

## 2.0.2

### Removed
- Removed version badge due to lack of update.

## 2.0.1

### Added
- Added badges to readme.

## 2.0.0

### Changed
- Require php 7.2+
- Updated code to comply with Coding Standard.

## 1.4.0

## Added
- Added class Is to check for various things i.e. date/time/datetime etc.

## 1.3.3

### Fixed
- Fixed missing constant names in Obj::getConstants().

## 1.3.2

### Fixed
- Fixed Arr::has().

## 1.3.1

### Fixed
- Fixed internal helper method in class Arr.

## 1.3.0

### Added
- Added Traits/DataTrait for generic data handling in class.

## 1.2.1

### Fixed
- Fixed has().

## 1.2.0

### Added
- Added Obj::getConstants().


## 1.1.0

### Added
- Added Bag::class.


## 1.0.0

### Added
- Initial development.
