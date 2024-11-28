import 'package:flutter/material.dart';

class Cart extends StatefulWidget {
  Cart({super.key});
  List list_broducts = [];
  // ignore: non_constant_identifier_names
  void add_broducts_to_list(Map broductDetails) {
    list_broducts.add(broductDetails);
    
  }
    // ignore: non_constant_identifier_names
    void delete_broduct_from_list() {

  }

  @override
  State<StatefulWidget> createState() {
    return _Cart();
  }
}

class _Cart extends State<Cart> {


  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        centerTitle: true,
        title: const Text(
          "Cart",
          style: TextStyle(fontSize: 23, fontWeight: FontWeight.w600),
        ),
        backgroundColor: const Color.fromARGB(255, 66, 252, 169),
      ),
      backgroundColor: Colors.white,
      body: Column(
        children: [
          (widget.list_broducts.isEmpty)
              ? Column(
                  children: [
                    Center(
                      child: Image.asset(
                        "Images/Cart.jpeg",
                        width: 500,
                      ),
                    ),
                    const Text(
                      "Cart is Empty..!!",
                      style: TextStyle(
                          fontSize: 25, fontWeight: FontWeight.w600),
                    )
                  ],
                )
              : Container(padding: const EdgeInsets.all(7),child:  ListView(children: [
                GridView(gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(crossAxisCount: 2,mainAxisSpacing: 10,crossAxisSpacing: 10),physics: NeverScrollableScrollPhysics(),shrinkWrap: true,
           
             children: [
             // ...List.generate(widget.list_broducts.length, (index) {}, ),
            ],
                
          
            ),],),),
        ],
      ),
    );
  }

}
