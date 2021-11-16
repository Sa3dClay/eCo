# eCo
## eCo is an eCommerce website where sellers can show their products to customers, and customers can search for products and purchase it.

## eCo Features
###
    1. Authintication (users can register, login and logout)
    2. Authorization (three types of users: admin, seller and customer)
        1. admin
            - manage all users and products (can add or remove any)
            - receive reports from users (to take action about it)
            - notified when user send a report about any problem
        2. seller
            - add new products
            - update and delete only his own products
            - notified when any action taken about his products (user purchase product or admin remove product)
        3. customer
            - search for products (by category, brand or name)
            - add products to cart
            - add products to wishlist
            - update his own cart and wishlist
            - checkout and recive report about his order
            - check his order status
            - notified when any action taken about his order (delivery will be late than reported)
    3. Notifications (for any changes that require taking actions)
    4. Reports
        - admin receive reports from users about problems or feedbacks
        - users receive reports after checkout operations
    5. Products (with CRUD operations)
        - seller can create, update or remove products
        - customer can purchase products
        - admin can remove products
    6. Cart (customer can add product here before check out)
        - customer can update the quantity of any product
        - can add more products or remove any
    7. Wishlist (customer can add liked products here)
        - can add more products or remove any
