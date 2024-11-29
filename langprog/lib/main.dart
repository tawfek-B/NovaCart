import 'package:flutter/material.dart';
import 'package:onboar/Home.dart';
import 'package:smooth_page_indicator/smooth_page_indicator.dart';
import 'package:shared_preferences/shared_preferences.dart';

Future main() async {
  WidgetsFlutterBinding.ensureInitialized();
  final prefs = await SharedPreferences.getInstance();
  final showHome = prefs.getBool('showHome') ?? false;
  runApp(MyApp(showHome:showHome));
}

class MyApp extends StatelessWidget {
final  bool showHome ;

  const MyApp({super.key, required this.showHome});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'OnBoarding',
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(seedColor: Colors.deepPurple),
        useMaterial3: true,
      ),
      home: showHome ? Home() :OnboardingPage(),
    );
  }
}

class OnboardingPage extends StatefulWidget {
  @override
  State<OnboardingPage> createState() => OnboardingPageState();
}

class OnboardingPageState extends State<OnboardingPage> {
  bool isLastPage = false;
  final pageController = PageController();

  @override
  void dispose() {
    pageController.dispose();
    super.dispose();
  }

  Widget buildPage({
    required String urlImage,
    required String title,
    required String discr,
  }) =>
      Container(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.spaceEvenly,
          children: [
            SizedBox(
              height: 60,
            ),
            Image.asset(
              urlImage,
              height: 250,
              fit: BoxFit.cover,
            ),
            SizedBox(
              height: 10,
            ),
            Text(
              title,
              style: TextStyle(fontSize: 26, fontWeight: FontWeight.bold),
            ),
            Container(
              padding: EdgeInsets.all(20),
              child: Text(
                discr,
                textAlign: TextAlign.center,
                style: TextStyle(
                  fontSize: 20,
                ),
              ),
            ),
          ],
        ),
      );

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.white,
      body: Container(
        padding: EdgeInsets.only(bottom: 80),
        child: PageView(
          onPageChanged: (value) {
            setState(() {
              isLastPage = value == 2;
            });
          },
          controller: pageController,
          children: [
            buildPage(
                urlImage: "images/9.png",
                title: "Select Item",
                discr:
                    "our new service make it easy for you to work anywhere ,there are new features will help you"),
            buildPage(
                urlImage: "images/7.png",
                title: "Add to Cart",
                discr:
                    "our new service make it easy for you to work anywhere ,there are new features will help you"),
            buildPage(
                urlImage: "images/1.png",
                title: "Fast Delivery",
                discr:
                    "our new service make it easy for you to work anywhere ,there are new features will help you"),
          ],
        ),
      ),
      bottomSheet: isLastPage
          ? Container(
              width: double.infinity,
              height: 80,
              color: Colors.grey,
              child: TextButton(
                  onPressed: ()async {
                    final prefs = await SharedPreferences.getInstance();
                    prefs.setBool('showHome', true);
                    Navigator.of(context).pushReplacement(MaterialPageRoute(builder: (context) => Home(),));
                  },
                  child: Text(
                    "Get Started ",
                    style: TextStyle(fontSize: 22),
                  )),
            )
          : Container(
              color: Colors.white,
              padding: EdgeInsets.all(10),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  TextButton(
                      onPressed: () => pageController.jumpToPage(2),
                      child: Text(
                        "Skip",
                        style: TextStyle(fontSize: 22),
                      )),
                  SmoothPageIndicator(
                    controller: pageController,
                    count: 3,
                    onDotClicked: (index) => pageController.animateToPage(index,
                        duration: Duration(milliseconds: 500),
                        curve: Curves.easeInOut),
                    effect: WormEffect(
                      spacing: 15,
                      activeDotColor: Colors.blue,
                    ),
                  ),
                  TextButton(
                      onPressed: () => pageController.nextPage(
                          duration: Duration(milliseconds: 500),
                          curve: Curves.easeInOut),
                      child: Text(
                        "Next",
                        style: TextStyle(fontSize: 22),
                      )),
                ],
              ),
            ),
    );
  }
}
