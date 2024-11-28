import 'package:flutter/material.dart';

class SignInPage extends StatefulWidget {
  @override
  // ignore: library_private_types_in_public_api
  _SignInPageState createState() => _SignInPageState();
}

class _SignInPageState extends State<SignInPage> {
  final _formKey = GlobalKey<FormState>();
  final _emailController = TextEditingController();
  final _passwordController = TextEditingController();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
         backgroundColor: Colors.white,
        body: Container(
            padding: EdgeInsets.all(16.0),
            margin: EdgeInsets.only(top: 50),
            alignment: Alignment.bottomCenter,
            child: Form(
                key: _formKey,
                child: Column(
                  children: [

                SizedBox(width: 500,height: 300,child:  Image.asset("Images/images.jpg",fit: BoxFit.cover,),),
                 Container(height: 20,),

                    const Text("Sign In",style: TextStyle(fontWeight: FontWeight.w800,fontSize: 20),),

                    Container(height: 15,),
                    TextFormField(
                      controller: _emailController,
                      decoration: InputDecoration(labelText: 'Email',enabledBorder: OutlineInputBorder(borderRadius: BorderRadius.circular(50))),
                      validator: (value) {
                        if (value == null || value.isEmpty) {
                          return 'Please enter your email';
                        }
                        return null;
                      },
                    ),
                    Container(height: 20,),
                    TextFormField(
                      controller: _passwordController,
                      decoration: InputDecoration(labelText: 'Password',enabledBorder: OutlineInputBorder(borderRadius: BorderRadius.circular(50))),
                      obscureText: true,
                      validator: (value) {
                        if (value == null || value.isEmpty) {
                          return 'Please enter your password';
                        }
                        return null;
                      },
                    ),
                    SizedBox(height: 30),
                    MaterialButton(
                      onPressed: () {
                        if (_formKey.currentState!.validate()) {
                          ScaffoldMessenger.of(context).showSnackBar(
                            const SnackBar(content: Text('Processing Data')),
                          );
                        }
                        Navigator.of(context).pushNamed("home page");
                      },color: Colors.blue[600],
                      child: const Text('Sign In'),
                    ),
                  ],
                ))));
  }
}
