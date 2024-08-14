import tensorflow as tf
from PIL import Image, ImageDraw, ImageFont
import random

# Exemple de génération de texte
def generate_text(product_name):
    slogans = [
        f"Découvrez notre nouveau {product_name} !",
        f"Promo spéciale sur {product_name} !",
        f"Le {product_name} parfait pour vous !"
    ]
    return random.choice(slogans)

# Exemple de création de la bannière
def create_banner(product_image_path, product_name, output_path):
    # Ouvrir l'image du produit
    product_image = Image.open(product_image_path).resize((300, 300))
    
    # Créer une nouvelle image pour la bannière
    banner = Image.new('RGB', (800, 400), 'white')
    draw = ImageDraw.Draw(banner)
    
    # Ajouter l'image du produit à la bannière
    banner.paste(product_image, (50, 50))
    
    # Générer le texte de la bannière
    text = generate_text(product_name)
    
    # Ajouter le texte à la bannière
    font = ImageFont.truetype("arial.ttf", 30)
    draw.text((400, 150), text, font=font, fill="black")
    
    # Sauvegarder la bannière
    banner.save(output_path)

# Exemple d'utilisation
product_image_path = 'C:/laragon/www/shop/images/sony_wh1000xm4.jpg'
product_name = 'Sac à Main'
output_path = 'C:/laragon/www/shop/images/abanner_gener.jpg'
create_banner(product_image_path, product_name, output_path)