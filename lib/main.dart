import 'package:flutter/material.dart';
import 'package:untitled/Broduct_Details.dart';
import 'package:untitled/HomePage.dart';
import 'package:untitled/StartApplication.dart';
import 'package:untitled/Trainnig.dart';
import 'package:untitled/ViewAll_Tees.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatefulWidget {
  const MyApp({super.key});
  @override
  State<MyApp> createState() => _MyAppState();
}

class _MyAppState extends State<MyApp> {
  @override
// TODO: implement widget
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      home: //Broduct_Details(name: "name", image:"Images/Cart.jpeg", describtion: "dgfsfgfsfg", amount: 5, price: 450, ID: 1),
          Start_Aplication(),
      title: "Nova Cart",
      routes: {
        
        "home page": (context) => const listgenerate_1(),
        "View All Tees": (context) => View_All_Tees(),
      },
      theme: ThemeData(
      appBarTheme:const AppBarTheme(color: Color.fromARGB(255, 66, 252, 169),) ,
        fontFamily: "PlaywriteGBS-Italic",
      ),
    );
  }
}
