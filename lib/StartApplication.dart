import 'package:curved_navigation_bar/curved_navigation_bar.dart';
import 'package:flutter/material.dart';
import 'package:untitled/Account.dart';
import 'package:untitled/Cart.dart';
import 'package:untitled/HomePage.dart';
import 'package:untitled/Trainnig.dart';

// ignore: must_be_immutable
class Start_Aplication extends StatefulWidget {
  Start_Aplication({super.key});
  @override
  State<StatefulWidget> createState() {
    return _Start_Aplication();
  }
}

class _Start_Aplication extends State<Start_Aplication> {
  int selectedindex = 0;
  List<Widget> Navigation_Bar = [listgenerate_1(),Trainning(),Cart(),Account()];

  GlobalKey<CurvedNavigationBarState> _bottomNavigationKey = GlobalKey();
  @override
  Widget build(BuildContext context) {
    return Scaffold(


 bottomNavigationBar: CurvedNavigationBar(
          key: _bottomNavigationKey,
          index: 0,
          items: const <Widget>[
 Icon( Icons.home_filled,  ),
Icon(  Icons.list),
Icon(  Icons.shopping_cart, ),
 Icon( Icons.account_circle_outlined, ),

          ],
          color: const Color.fromARGB(255, 66, 252, 169),
          buttonBackgroundColor: Color.fromARGB(255,  120, 191, 249) ,  // const Color.fromARGB(255, 36, 175, 135),
          backgroundColor: const Color.fromARGB(255, 251, 252, 253),
          animationCurve: Curves.easeInOut,
          animationDuration: Duration(milliseconds: 600),
          onTap: (index) {
            setState(() {
              selectedindex = index;
            });
          },
          letIndexChange: (index) => true,
        ),
  
      body:
       Navigation_Bar.elementAt(selectedindex),
  
    );
  }
}
