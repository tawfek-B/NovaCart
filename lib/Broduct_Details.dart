// ignore: file_names

import 'package:flutter/material.dart';
import 'package:http/http.dart';
import 'package:untitled/Cart.dart';

// ignore: camel_case_types, must_be_immutable
class Broduct_Details extends StatefulWidget {
  String image;
  String name;
  String describtion;
  int amount;
  int ID;
  int price;
  Broduct_Details(
      {super.key,
      required this.name,
      required this.image,
      required this.describtion,
      required this.amount,
      required this.price,
      required this.ID});
  @override
  State<StatefulWidget> createState() {
    // ignore: no_logic_in_create_state
    return _Broduct_Details();
  }
}

// ignore: camel_case_types
class _Broduct_Details extends State<Broduct_Details> {
  // ignore: non_constant_identifier_names
  GlobalKey<ScaffoldState> Scaffold_Key = GlobalKey();
  // ignore: non_constant_identifier_names
  int amount_customer = 0;
  bool loading = true;
  // ignore: non_constant_identifier_names
  List list_details = ["name", 'https://images.unsplash.com/photo-1606112219348-204d7d8b94ee', "dgfsfgfsfg", 5];
  void initstate() {
    super.initState();
    getData();
  }

  Future<List> getData() async {
    // var response = await post(Uri.parse(""), headers: {"id": "${widget.ID}"});

    // var responseBody = jsonDecode(response.body);
    // list_details.addAll(responseBody);
    return list_details;
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        key: Scaffold_Key,
        appBar: AppBar(
          centerTitle: true,
          title: const Text("Broduct Details"),
          backgroundColor: const Color.fromARGB(255, 66, 252, 169),
        ),
        body: Column(children: <Widget>[
          (!list_details.isEmpty)
              ? Column(
                  children: [
                    SizedBox(
                      height: 300,
                      child: Image.network(
                        list_details[1],
                        fit: BoxFit.cover,
                      ),
                    ),
                    Container(
                      height: 20,
                    ),
                    Text(
                      list_details[0],
                      style: const TextStyle(
                          fontWeight: FontWeight.w800, fontSize: 30),
                    ),
                    Container(
                      height: 20,
                    ),
                    Container(
                      height: 80,
                      padding: const EdgeInsets.only(left: 20),
                      child: Text(
                        list_details[2],
                        style: const TextStyle(
                            fontSize: 15, fontWeight: FontWeight.w500),
                      ),
                    ),
                    Container(
                      height: 50,
                    ),
                    Row(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        IconButton(
                          onPressed: () {
                            setState(() {
                              if (amount_customer != 0) {
                                amount_customer--;
                              }
                            });
                          },
                          icon: const Icon(
                            Icons.remove,
                          ),
                          color: const Color.fromARGB(255, 231, 30, 30),
                          iconSize: 25,
                        ),
                        Container(
                          margin: const EdgeInsets.symmetric(horizontal: 25),
                          child: Text('$amount_customer',style: TextStyle(fontSize: 18),),
                        ),
                        IconButton(
                          onPressed: () {
                            if (amount_customer < list_details[3]) {
                              amount_customer++;
                              setState(() {});
                            }
                          },
                          icon: const Icon(
                            Icons.add,
                          ),
                          color: const Color.fromARGB(255, 46, 225, 139),
                          iconSize: 25,
                        )
                      ],
                    ),
                    MaterialButton(
                      onPressed: () {
                        if (amount_customer <= list_details[3]) {
                          Cart().add_broducts_to_list({});
                          ScaffoldMessenger.of(context)
                              .showSnackBar(const SnackBar(
                            content: Text(
                              "Added  Successfully...",
                              style: TextStyle(
                                  color: Color.fromARGB(255, 10, 10, 10),
                                  fontWeight: FontWeight.w500,
                                  fontSize: 15),
                            ),
                            duration: Duration(seconds: 3),
                            backgroundColor:
                                const Color.fromARGB(255, 66, 252, 169),
                            padding: EdgeInsets.all(18),
                          ));
                        }
                      },
                      child: Container(
                        decoration: BoxDecoration(
                          borderRadius: BorderRadius.circular(50),
                          color: const Color.fromARGB(255, 66, 252, 169),
                        ),
                        height: 40,
                        width: 150,
                        alignment: Alignment.center,
                        child: const Text(
                          "add to cart",
                          style: TextStyle(
                              fontSize: 15, fontWeight: FontWeight.w600),
                        ),
                      ),
                    )
                  ],
                )
              :  Container(alignment: Alignment.center, padding: EdgeInsets.only(top: 200),child:  
                   const Text(
                    "the data does not load !!!!!",
                    style: TextStyle(fontSize: 20, color: Colors.red),
                  ) 
               ,)
        ]));
  }
}
