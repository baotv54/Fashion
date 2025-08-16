from flask import Flask, request, jsonify
from PIL import Image
import torch
from torchvision import models, transforms
import numpy as np
import io

app = Flask(__name__)

# Load pretrained model (ResNet50)
model = models.resnet50(pretrained=True)
model.eval()

# Remove last layer to get feature vector
feature_extractor = torch.nn.Sequential(*list(model.children())[:-1])

def extract_vector(image_bytes):
    img = Image.open(io.BytesIO(image_bytes)).convert('RGB')
    preprocess = transforms.Compose([
        transforms.Resize(256),
        transforms.CenterCrop(224),
        transforms.ToTensor(),
    ])
    input_tensor = preprocess(img).unsqueeze(0)
    with torch.no_grad():
        features = feature_extractor(input_tensor)
    return features.squeeze().numpy().flatten().tolist()

@app.route('/extract-vector', methods=['POST'])
def extract():
    if 'image' not in request.files:
        return jsonify({'error': 'No image uploaded'}), 400
    image = request.files['image'].read()
    vector = extract_vector(image)
    return jsonify({'vector': vector})

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5001)
