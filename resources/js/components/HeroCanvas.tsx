import { Canvas } from '@react-three/fiber';
import { useGLTF, OrbitControls } from '@react-three/drei';
import { Suspense } from 'react';

function Model() {
  const { scene } = useGLTF('/storage/models/hero.glb');
  return <primitive object={scene} scale={1.5} rotation={[0, Math.PI / 4, 0]} />;
}

export default function HeroCanvas() {
  return (
    <Canvas shadows camera={{ position: [0, 0, 4], fov: 45 }}>
      <ambientLight intensity={0.6} />
      <directionalLight position={[2, 3, 2]} intensity={2} />
      <Suspense fallback={null}>
        <Model />
      </Suspense>
      <OrbitControls autoRotate autoRotateSpeed={2} enableZoom={false} />
    </Canvas>
  );
}
