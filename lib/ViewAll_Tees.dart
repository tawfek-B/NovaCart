
import 'package:flutter/material.dart';
import 'package:untitled/HomePage.dart';

// ignore: must_be_immutable
 class View_All_Tees  extends StatefulWidget {
  View_All_Tees({super.key});

  @override
  State<StatefulWidget> createState() {
    return _View_All_Tees();
  }
}

class _View_All_Tees extends State<View_All_Tees> {
  
   List Cards = [
    Clothes_Custom(image: 'Images/image_applications.jpg', price: 28),
    Clothes_Custom(image: 'Images/image_applications.jpg', price: 22),
    Clothes_Custom(image: 'Images/image_applications.jpg', price: 88),
    Clothes_Custom(image: 'Images/image_applications.jpg', price: 12),
    Clothes_Custom(image: 'Images/image_applications.jpg', price: 28),
    Clothes_Custom(image: 'Images/image_applications.jpg', price: 90),
     Clothes_Custom(image: 'Images/image_applications.jpg', price: 88),
    Clothes_Custom(image: 'Images/image_applications.jpg', price: 12),
    Clothes_Custom(image: 'Images/image_applications.jpg', price: 28),
    Clothes_Custom(image: 'Images/image_applications.jpg', price: 90),
  ];
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(centerTitle: true,title: Text("View All Tess"),backgroundColor: Colors.blueAccent,),  
body:Container(child:  ListView(children: [GridView(gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(crossAxisCount: 2,mainAxisSpacing: 10,crossAxisSpacing: 10),physics: NeverScrollableScrollPhysics(),shrinkWrap: true,
           
             children: [...List.generate(Cards.length, (index) {
                  return Cards[index];
                },),],
                
          
            ),],),padding: EdgeInsets.all(7),),

    );
  

        }
      
   
  
       
    
  }
