import 'dart:io';

import 'package:flutter/material.dart';
import 'package:geolocator/geolocator.dart';
import 'package:image_picker/image_picker.dart';

class Trainning extends StatefulWidget {
  const Trainning({super.key});
  @override
  State<Trainning> createState() => TrainningState();
}

class TrainningState extends State<Trainning> {
  @override
  Widget build(BuildContext context) {
    // TODO: implement build
    return Scaffold(
        appBar: AppBar(
          title: const Text(
            "flutter mobile",
            style: TextStyle(
                color: Colors.amber, fontSize: 20, fontWeight: FontWeight.w500),
          ),
          centerTitle: false,
          backgroundColor: Colors.blue,
        ),
        body: Column(children: [
          Container(
            child: GeolocatorExample(),
            height: 200,
          )
        ]));
  }
}

// class Image_Profile extends StatefulWidget {
//   Image_Profile({super.key});
// String? image_profile;
//   @override
//   State<StatefulWidget> createState() {
//     return _Image_Profile();
//   }
// }

//   class _Image_Profile extends State<Image_Profile> {

//   File? _profileImage;

//   final ImagePicker _picker = ImagePicker();
//   Future<void> _pickImage() async {
//     final pickedFile = await _picker.pickImage(source: ImageSource.gallery);
//     if (pickedFile != null) {
//       setState(() {
//         _profileImage = File(pickedFile.path);
//       });
//       //  image_profile = pickedFile.path;
//     }
//   }

//   @override
//   Widget build(BuildContext context) {
//     return Scaffold(
//       body: Center(
//         child: GestureDetector(
//           onTap: _pickImage,
//           child: CircleAvatar(
//             radius: 50,
//             backgroundImage: _profileImage != null
//                 ? FileImage(_profileImage!)
//                 : AssetImage('assets/default_avatar.png'),
//             child: _profileImage == null
//                 ? const Icon(
//                     Icons.camera_alt,
//                     size: 35,
//                   )
//                 : null,
//           ),
//         ),
//       ),
//     );
//   }

// }



class GeolocatorExample extends StatefulWidget {
  @override
  _GeolocatorExampleState createState() => _GeolocatorExampleState();
}

class _GeolocatorExampleState extends State<GeolocatorExample> {
  Position? _currentPosition;
  Future<void> _getCurrentLocation() async {
    bool serviceEnabled;
    LocationPermission permission; // التحقق من تمكين خدمة الموقع
    serviceEnabled = await Geolocator.isLocationServiceEnabled();
    if (!serviceEnabled) {
      // لا يمكن الحصول على الموقع بدون تمكين الخدمة
      return;
    }
    // التحقق من الأذونات
    permission = await Geolocator.checkPermission();
    if (permission == LocationPermission.denied) {
      permission = await Geolocator.requestPermission();
      if (permission == LocationPermission.denied) {
        // لا توجد إذن للوصول إلى الموقع
        return;
      }
    }
    if (permission == LocationPermission.deniedForever) {
      // لا يمكن الحصول على الإذن للوصول إلى الموقع
      return;
    }
    // الحصول على الموقع الحالي
    Position position = await Geolocator.getCurrentPosition(
        desiredAccuracy: LocationAccuracy.high);
    setState(() {
      _currentPosition = position;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        appBar: AppBar(
          title: Text('Geolocator Example'),
        ),
        body: Center(
            child: _currentPosition == null
                ? ElevatedButton(
                    onPressed: _getCurrentLocation,
                    child: Text('Get Location'),
                  )
                : Text(
                    'Latitude: ${_currentPosition!.latitude}, Longitude: ${_currentPosition!.longitude}')));
  }
}
