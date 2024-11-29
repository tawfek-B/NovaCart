import 'package:flutter/material.dart';
import 'package:onboar/main.dart';
import 'package:shared_preferences/shared_preferences.dart';

class Home extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Home page"),
        backgroundColor: Colors.blue,
        actions: [
          IconButton(onPressed: () async{
            final prefs = await SharedPreferences.getInstance();
            prefs.setBool('showHome', false);
            Navigator.of(context).push(MaterialPageRoute(builder: (context) => OnboardingPage(),));
          }, icon: Icon(Icons.logout)),
        ],
      ),
      body: Center(
        child: Text("Home Page"),
      ),
    );
  }
}
