import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart';
import 'package:geolocator/geolocator.dart';

class listgenerate_1 extends StatefulWidget {
  const listgenerate_1({super.key});

  @override
  State<StatefulWidget> createState() {
    // TODO: implement createState
    return _listgenerate_1();
  }
}

class _listgenerate_1 extends State<listgenerate_1> {
  int selectedindex = 0;
  late BuildContext context;
  List pageviewImage = [
    Image.asset(
      'Images/image_applications.jpg',
      fit: BoxFit.cover,
    ),
    Image.asset('Images/images.jpg', fit: BoxFit.contain),
    Image.asset('Images/images.jpg', fit: BoxFit.fitWidth),
  ];
  List Widget_Cards = [
    Clothes_Custom(image: 'Images/image_applications.jpg', price: 28),
    Clothes_Custom(image: 'Images/image_applications.jpg', price: 22),
    Clothes_Custom(image: 'Images/image_applications.jpg', price: 88),
    Clothes_Custom(image: 'Images/image_applications.jpg', price: 12),
    Clothes_Custom(image: 'Images/image_applications.jpg', price: 28),
    Clothes_Custom(image: 'Images/image_applications.jpg', price: 90),
  ];

  Type get buildcontext => BuildContext;

  Future<Position> _determinePosition() async {
    bool serviceEnabled;
    LocationPermission permission;

    // Test if location services are enabled.
    serviceEnabled = await Geolocator.isLocationServiceEnabled();
    if (!serviceEnabled) {
      // Location services are not enabled don't continue
      // accessing the position and request users of the
      // App to enable the location services.
      return Future.error(
          "please operate service arrive to your application.....");
    }

    permission = await Geolocator.checkPermission();
    if (permission == LocationPermission.denied) {
      permission = await Geolocator.requestPermission();
      if (permission == LocationPermission.denied) {
        // Permissions are denied, next time you could try
        // requesting permissions again (this is also where
        // Android's shouldShowRequestPermissionRationale
        // returned true. According to Android guidelines
        // your App should show an explanatory UI now.
        return Future.error('Location permissions are denied');
      }
    }
    if (permission == LocationPermission.whileInUse) {
      Position position = await Geolocator.getCurrentPosition();
      print("****************");
      print(position.latitude);
      print(position.longitude);
      print("****************");
    }

    if (permission == LocationPermission.deniedForever) {
      // Permissions are denied forever, handle appropriately.
      return Future.error(
          'Location permissions are permanently denied, we cannot request permissions.');
    }

    // When we reach here, permissions are granted and we can
    // continue accessing the position of the device.
    return await Geolocator.getCurrentPosition();
  }

  getData() async {
    var response =
        await get(Uri.parse('https://jsonplaceholder.typicode.com/postsggg'));
    var responselist = jsonDecode(response.body);
    //  data.addAll(responselist);
//loading = false;
    setState(() {});
  }

  void initstate() {
    _determinePosition();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    // TODO: implement build
    return Scaffold(
        appBar: AppBar(
          backgroundColor: const Color.fromARGB(255, 66, 252, 169),
          actions: [
           Container(width: 30,),
            Expanded(
              // ignore: sized_box_for_whitespace
              child: Container(
                height: 38,
                child: TextField(
                  decoration: const InputDecoration(
                      labelText: 'Search Product',
                      prefixIcon: Icon(Icons.search),
                      fillColor: Colors.white,
                      filled: true,
                      border: OutlineInputBorder(
                          borderRadius: BorderRadius.all(Radius.circular(50))),
                      contentPadding: EdgeInsets.all(0.0)),
                  onTap: () {
                    showSearch(context: context, delegate: CustomSearch());
                  },
                ),
              ),
            ),
           Container(width: 30,),
          ],
        ),
        body: Container(
          child: ListView(children: [
            Container(
              //page view
              margin: EdgeInsets.all(9),
              height: 200,
              child: PageView.builder(
                itemCount: pageviewImage.length,
                itemBuilder: (context, index) {
                  return pageviewImage[index];
                },
              ),
            ),
            Container(
              height: 25,
            ),
            ListTile(
              //Tees
              title: Text(
                "Tees",
                style: TextStyle(fontSize: 30),
              ),
              trailing: TextButton(
                  onPressed: () {
                    Navigator.of(context).pushNamed("View All Tees");
                  },
                  child: Text("View All")),
              subtitle: Text(" "),
              isThreeLine: true,
            ),

            SingleChildScrollView(
              scrollDirection: Axis.horizontal,
              child: Row(
                children: List.generate(Widget_Cards.length, (index) {
                  return Widget_Cards[index];
                }),
              ),
            ),

            ListTile(
              title: Text(
                "Jackets",
                style: TextStyle(fontSize: 30),
              ),
              trailing: TextButton(onPressed: () {}, child: Text("View All")),
              subtitle: Text(" "),
              isThreeLine: true,
            ),

            SingleChildScrollView(
              scrollDirection: Axis.horizontal,
              child: Row(
                children: List.generate(Widget_Cards.length, (index) {
                  return Widget_Cards[index];
                }),
              ),
            ),

            // FutureBuilder(
            //   future: getData(),
            //   builder: (context, snapshot) {
            //     if (snapshot.connectionState == ConnectionState.waiting)
            //       return Center(
            //         child: CircularProgressIndicator(),
            //       );
            //     if (snapshot.connectionState == ConnectionState.done) {
            //       if (snapshot.hasError)
            //         return Container(
            //           child: Text(
            //             "Error.!!!!!!",
            //             style: TextStyle(
            //                 fontSize: 30,
            //                 color: const Color.fromARGB(255, 236, 17, 2),
            //                 fontWeight: FontWeight.w700),
            //           ),
            //           alignment: Alignment.center,
            //         );
            //     }
            //     return ListView.builder(
            //       itemBuilder: (context, index) => Card(
            //         child: ListTile(
            //           title: Text("${data[index]['title']}"),
            //           subtitle: Text("${data[index]['body']}"),
            //         ),
            //       ),
            //       itemCount: data.length,
            //     );
            //   },
            // )
          ]),
          padding: EdgeInsets.all(7),
        ));

    /* MaterialButton(
            onPressed: () {
              AwesomeDialog(
                context: context,
                dialogType: DialogType.info,
                animType: AnimType.rightSlide,
                title: 'Dialog Title',
                desc: 'Dialog description here.............',
                btnCancelOnPress: () {},
                btnOkOnPress: () {},
              ).show();
            },
            color: Colors.red,
            child: Text("show dialog"),
          ),
          MaterialButton(
            onPressed: () async {
              loading = true;

              setState(() {});

              var response = await get(
                  Uri.parse('https://jsonplaceholder.typicode.com/todos/1'));
              var responselist = jsonDecode(response.body);
              loading = false;
              setState(() {});
              Card(
                  child: ListTile(
                title: Text("$responselist<'name'>"),
              ));
              setState(() {
                
              });
            },
            child: Text("show dialog"),
            color: Colors.red,
          ),*/
  }
}

class CustomSearch extends SearchDelegate {
  List listsuggestions = ["anas ", "wael", "ali ", "mohanad", "mohamad"];
  List suggestions = [];
  @override
  List<Widget>? buildActions(BuildContext context) {
    return [
      IconButton(
          onPressed: () {
            query = "";
          },
          icon: const Icon(Icons.multiline_chart_sharp))
    ];
  }

  @override
  Widget? buildLeading(BuildContext context) {
    return IconButton(
        onPressed: () {
          close(context, null);
        },
        icon: const Icon(Icons.arrow_back));
  }

  @override
  Widget buildResults(BuildContext context) {
    return const Text("data");
  }

  @override
  Widget buildSuggestions(BuildContext context) {
    if (query == "") {
      return ListView.builder(
        itemBuilder: (context, i) {
          return InkWell(
            child: Card(
              color: Colors.grey[350],
              child: Text(
                "${listsuggestions[i]}",
                style: const TextStyle(fontSize: 16),
              ),
            ),
            onTap: () => showResults(context),
          );
        },
        itemCount: listsuggestions.length,
      );
    } else {
      suggestions = listsuggestions
          .where((element) => listsuggestions.contains(query))
          .toList();
      return ListView.builder(
        itemCount: suggestions.length,
        itemBuilder: (context, i) {
          return Text("${suggestions[i]}");
        },
      );
    }
  }
}

// ignore: must_be_immutable
class Clothes_Custom extends StatefulWidget {
  late String image;
  late int price;
  Clothes_Custom({required this.image, required this.price});
  @override
  State<StatefulWidget> createState() {
    return _Clothes_Custom();
  }
}

class _Clothes_Custom extends State<Clothes_Custom> {
  @override
  Widget build(BuildContext context) {
    return Container(
      child: Card(
        child: Column(
          children: [
            Image.asset(
              widget.image,
            ),
        Expanded(child:   ListTile(
              title: Text("Atomic Endurance",style: TextStyle(fontSize: 15),),
              subtitle: Text(" sdgsdg"),
            contentPadding: EdgeInsets.all(3),),),
             Text(
              "Rs.${widget.price}",
              style: TextStyle(fontSize: 15, fontWeight: FontWeight.w800),
            ),
          ],
        ),
      ),
      width: 170,
      height: 210,
    );
  }
}
