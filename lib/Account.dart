import 'package:awesome_dialog/awesome_dialog.dart';
import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:untitled/Trainnig.dart';

// ignore: must_be_immutable
class Account extends StatefulWidget {
  Account({super.key});
  @override
  State<StatefulWidget> createState() {
    return _Account();
  }
}

class _Account extends State<Account> {
  GlobalKey<ScaffoldState> change_language = GlobalKey();
 // String? image_profile=Image_Profile().image_profile;
  String language = "english";
  

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        key: change_language,
        body: Container(
          child: ListView(
            children: [
              Container(
                child: Row(
                  children: [
                    Container(
                      width: 15,
                    ),
                    Container(
                      child: ClipRRect(
                        borderRadius: BorderRadius.all(Radius.circular(50)),
                        child: Image.asset("Images/images.jpg",
                      // image_profile!,
                         fit: BoxFit.cover,
                        ),
                      ),
                      width: 60,
                      height: 60,
                    ),
                    Container(
                      width: 30,
                      height: 30,
                    ),
                    Column(
                      children: [
                        Text("data"),
                        SizedBox(
                          height: 8,
                        ),
                        Text("data")
                      ],
                      mainAxisAlignment: MainAxisAlignment.center,
                    )
                  ],
                ),
                height: 180,
                margin: EdgeInsets.only(bottom: 15),
                color: const Color.fromARGB(255, 120, 191, 249),
              ),
              InkWell(
                child: Card(
                  child: Container(
                    child: ListTile(
                      leading: Icon(
                        Icons.favorite_border_outlined,
                        color: Colors.blueAccent,
                      ),
                      title: Text(
                        "My Favourites",
                        style: TextStyle(fontWeight: FontWeight.w600),
                      ),
                      trailing: Icon(Icons.chevron_right),
                    ),
                    height: 70,
                    padding: EdgeInsets.only(top: 8),
                  ),
                  margin: EdgeInsets.all(8),
                ),
              ),
              InkWell(
                child: Card(
                  child: Container(
                    child: ListTile(
                      leading: Icon(
                        Icons.add_road_rounded,
                        color: Colors.blueAccent,
                      ),
                      title: Text(
                        "My Favourites",
                        style: TextStyle(fontWeight: FontWeight.w600),
                      ),
                      trailing: Icon(Icons.next_plan),
                    ),
                    height: 70,
                    padding: EdgeInsets.only(top: 8),
                  ),
                  margin: EdgeInsets.all(8),
                ),
              ),
              InkWell(
                child: Card(
                  child: Container(
                    child: ListTile(
                      leading: Icon(
                        Icons.language,
                        color: Colors.blueAccent,
                      ),
                      title: Text(
                        "Language",
                        style: TextStyle(fontWeight: FontWeight.w600),
                      ),
                      trailing: Icon(Icons.chevron_right),
                    ),
                    height: 70,
                    padding: EdgeInsets.only(top: 8),
                  ),
                  margin: EdgeInsets.all(8),
                ),
                onTap: () {
                  change_language.currentState!.showBottomSheet((context) =>
                      Container(
                        child: Column(
                          children: [
                            RadioListTile(
                              value: "arabic",
                              groupValue: language,
                              onChanged: (value) {
                                setState(() {
                                  language = value!;
                                });
                              },
                              title: Text("arabic"),
                            ),
                            RadioListTile(
                              value: "english",
                              groupValue: language,
                              onChanged: (val) {
                                setState(() {
                                  language = val!;
                                });
                              },
                              title: Text("English"),
                            ),
                            SizedBox(
                              height: 12,
                            ),
                            SizedBox(
                              child: MaterialButton(
                                  onPressed: () {},
                                  child: Text(
                                    "Save",
                                    style: TextStyle(
                                      fontSize: 25,
                                      fontWeight: FontWeight.w600,
                                    ),
                                  ),
                                  textColor:
                                      const Color.fromARGB(255, 14, 14, 8),
                                  color:
                                      const Color.fromARGB(228, 71, 212, 160),
                                  shape: RoundedRectangleBorder(
                                      borderRadius: BorderRadius.circular(20))),
                              width: 170,
                            )
                          ],
                        ),
                        padding: EdgeInsets.all(10),
                        height: 200,
                        decoration: BoxDecoration(
                            borderRadius:
                                BorderRadius.vertical(top: Radius.circular(40)),
                            color: const Color.fromARGB(255, 251, 251, 251)),
                      ));
                },
              ),
              InkWell(
                  child: Card(
                    child: Container(
                      child: ListTile(
                        leading: Icon(
                          Icons.contact_page,
                          color: Colors.blueAccent,
                        ),
                        title: Text(
                          "contact us",
                          style: TextStyle(fontWeight: FontWeight.w600),
                        ),
                        trailing: Icon(Icons.chevron_right),
                      ),
                      height: 70,
                      padding: EdgeInsets.only(top: 8),
                    ),
                    margin: EdgeInsets.all(8),
                  ),
                  onTap: () => Navigator.of(context).push(
                        MaterialPageRoute(builder: (context) => Contact_Us()),
                      )),
              InkWell(
                child: Card(
                  child: Container(
                    child: ListTile(
                      leading: Icon(
                        Icons.face_unlock_rounded,
                        color: Colors.blueAccent,
                      ),
                      title: Text(
                        "Who Us",
                        style: TextStyle(fontWeight: FontWeight.w600),
                      ),
                      trailing: Icon(Icons.chevron_right_rounded),
                    ),
                    height: 70,
                    padding: EdgeInsets.only(top: 8),
                  ),
                  margin: EdgeInsets.all(8),
                ),
                onTap: () => Navigator.of(context)
                    .push(MaterialPageRoute(builder: (context) => Who_Us())),
              ),
              InkWell(
                child: Card(
                  child: Container(
                    child: ListTile(
                      leading: Icon(
                        Icons.logout,
                        color: Colors.blueAccent,
                      ),
                      title: Text(
                        "Log Out",
                        style: TextStyle(fontWeight: FontWeight.w600),
                      ),
                      trailing: Icon(Icons.chevron_right),
                    ),
                    height: 70,
                    padding: EdgeInsets.only(top: 8),
                  ),
                  margin: EdgeInsets.all(8),
                ),
                onTap: () {
                  AwesomeDialog(
                    context: context,
                    dialogType: DialogType.question,
                    descTextStyle:
                        TextStyle(fontSize: 17, fontWeight: FontWeight.w400),
                    dialogBorderRadius: BorderRadius.circular(20),
                    desc: 'Are you sure you want to log out?',
                    btnCancelOnPress: () {},
                    btnOkOnPress: () {},
                  )..show();
                },
              ),
            ],
            //padding: EdgeInsets.all(13),
          ),
        ));
  }
}

class Who_Us extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
        backgroundColor: const Color.fromARGB(255, 249, 247, 247),
        appBar: AppBar(
          centerTitle: true,
          title: Text("Who Us ?"),
          backgroundColor: const Color.fromARGB(255, 66, 252, 169),
        ),
        body: Container(
          padding: EdgeInsets.all(15),
          child: Column(
            children: [
              Container(
                child: Text(
                  "Who Us",
                  style: TextStyle(fontWeight: FontWeight.w800),
                ),
                padding: EdgeInsets.all(5),
              ),
              Container(
                child: Text(
                  "The Nova Cart is committed to providing first-class delivery services to its customers around the clock, seven days a week. We challenge ourselves to continuously exceed our customers' expectations by offering innovative solutions to their needs.",
                  style: TextStyle(
                    fontSize: 15,
                    fontWeight: FontWeight.w500,
                  ),
                ),
                padding: EdgeInsets.all(5),
                color: Colors.white,
              )
            ],
          ),
        ));
  }
}

class Contact_Us extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
        backgroundColor: const Color.fromARGB(255, 253, 252, 252),
        appBar: AppBar(
          centerTitle: true,
          title: Text("Contact Us"),
          backgroundColor: const Color.fromARGB(255, 66, 252, 169),
        ),
        body: Container(
          child: Column(
            children: [
              Container(
                child: Image.asset("Images/photo_2024-11-22_12-03-48.jpg"),
                margin: EdgeInsets.only(bottom: 20),
              ),
              Container(
                child: Row(
                  children: [
                    Container(
                      child: Icon(
                        Icons.phone,
                        size: 35,
                      ),
                      padding: EdgeInsets.only(left: 10),
                    ),
                    Container(
                      child: Text(
                        "0964652593",
                        style: TextStyle(
                            fontWeight: FontWeight.w800, fontSize: 15),
                      ),
                      padding: EdgeInsets.only(left: 48),
                    )
                  ],
                ),
                decoration: BoxDecoration(
                    borderRadius: BorderRadius.circular(30),
                    color: Colors.greenAccent),
                height: 55,
                width: 270,
                margin: EdgeInsets.all(20),
              ),
              Container(
                child: Row(
                  children: [
                    Container(
                      child: Icon(
                        Icons.email,
                        size: 35,
                      ),
                      padding: EdgeInsets.only(left: 10),
                    ),
                    Container(
                      child: Text(
                        "admin@nova_cart.net",
                        style: TextStyle(
                            fontWeight: FontWeight.w800, fontSize: 15),
                      ),
                      padding: EdgeInsets.only(left: 40),
                    )
                  ],
                ),
                decoration: BoxDecoration(
                    borderRadius: BorderRadius.circular(30),
                    color: Colors.greenAccent),
                height: 60,
                width: 270,
                margin: EdgeInsets.all(20),
              ),
              Container(
                child: Row(
                  children: [
                    Container(
                      child: Icon(
                        Icons.facebook,
                        size: 35,
                      ),
                      padding: EdgeInsets.only(left: 10),
                    ),
                    Container(
                      child: Text(
                        "@Nova Cart",
                        style: TextStyle(
                            fontWeight: FontWeight.w800, fontSize: 15),
                      ),
                      padding: EdgeInsets.only(left: 40),
                    )
                  ],
                ),
                decoration: BoxDecoration(
                    borderRadius: BorderRadius.circular(30),
                    color: Colors.greenAccent),
                height: 60,
                width: 270,
                margin: EdgeInsets.all(20),
              ),
            ],
          ),
        ));
  }
}
